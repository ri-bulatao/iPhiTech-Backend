<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User as UserModel;
use App\Models\UserAddress as UserAddressModel;
use App\Utilities\Result;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @var Result
     */
    private $result;

    public function __construct(Result $result)
    {
        $this->result = $result;
    }
    /**
     * For Fetching all users.
     */
    public function index(): JsonResponse
    {
        // Except ID #1 - Admin
        $users = UserModel::with('position')->filter('id', 'DESC')->except(1);

        return $this->result->success($users);
    }

    /**
     * For Fetching single user.
     */
    public function get($id): JsonResponse
    {
        $user = UserModel::with(['position', 'user_address'])->find($id);

        return $this->result->success($user);
    }

    /**
     * For Storing new user.
     */
    public function store(UserRequest $request): JsonResponse
    {

        // Check if admin trying to change the password
        $new_password = '';
        if ($request->new_password != '') {
            // Encrypt the password
            $new_password = bcrypt($request->new_password);
        }

        $emergency_contact = [
            'full_name'     =>  $request->ec_full_name,
            'relationship'  =>  $request->ec_relationship,
            'phone_number'  =>  $request->ec_phone_number,
        ];

        $data = [
            'first_name'        => $request->first_name,
            'middle_name'       => $request->middle_name,
            'last_name'         => $request->last_name,
            'phone_number'      => $request->phone_number,
            'email'             => $request->email,
            'gender'            => $request->gender,
            'marital_status'    => $request->marital_status,
            'date_of_birth'     => $request->date_of_birth,
            'password'          => $new_password,
            'position_id'       => $request->position,
            'emergency_contact' => json_encode($emergency_contact),
        ];

        $user = UserModel::create($data);

        // User Address
        $address_data = [
            'user_id'           => $user->id,
            'street_address'    => $request->street_address,
            'city'              => $request->city,
            'state'             => $request->state,
            'zip_code'          => $request->zip_code,
            'country'           => $request->country,
        ];

        $user_address = UserAddressModel::create($address_data);

        if (! $user && ! $user_address) {
            return $this->result->exception();
        }

        return $this->result->created($user, 'User created!');
    }

    /**
     * For Updating single user.
     */
    public function update(UserRequest $request, $id): JsonResponse
    {
        $user = UserModel::find($id);
        $user->update($request->only('first_name', 'middle_name', 'last_name', 'phone_number', 'email', 'gender', 'marital_status', 'date_of_birth'));

        $emergency_contact = [
            'full_name'     =>  $request->ec_full_name,
            'relationship'  =>  $request->ec_relationship,
            'phone_number'  =>  $request->ec_phone_number,
        ];

        // Check if admin trying to change the password
        if ($request->new_password != '') {
            // Encrypt the password
            $new_password = bcrypt($request->new_password);
            $user->password = $new_password;
        }

        $user->emergency_contact = json_encode($emergency_contact);
        $user->position_id = $request->position;
        $user->save();

        // Update User Address Model
        $user_address = UserAddressModel::where('user_id', $user->id)->first();
        if (! empty($user_address)) {
            $user_address->update($request->only('street_address', 'city', 'state', 'zip_code', 'country'));
        } else {
            // User Address
            $address_data = [
                'user_id'           => $user->id,
                'street_address'    => $request->street_address,
                'city'              => $request->city,
                'state'             => $request->state,
                'zip_code'          => $request->zip_code,
                'country'           => $request->country,
            ];

            UserAddressModel::create($address_data);
        }

        return $this->result->success($user, 'User updated!');
    }

    /**
     * For Removing single user.
     */
    public function destroy($id): JsonResponse
    {
        $user = UserModel::find($id);
        $user->delete();

        $user_address = UserAddressModel::where('user_id', $id)->first();
        if ($user_address) {
            $user_address->delete();
        }

        return $this->result->success($user, 'User deleted!');
    }
}
