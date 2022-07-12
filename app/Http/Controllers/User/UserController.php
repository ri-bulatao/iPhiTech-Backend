<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User as UserModel;
use App\Models\UserAddress as UserAddressModel;
use App\Utilities\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var Authenticatable
     */
    private $user;

    /**
     * @var Result
     */
    private $result;

    public function __construct(Result $result)
    {
        $this->user = auth()->user();
        $this->result = $result;
    }

    /**
     * For Fetching all users.
     * Excep the Admin user.
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

        if (! $user) {
            return $this->result->notFound();
        }

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

        $emergencyContact = [
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
            'emergency_contact' => json_encode($emergencyContact),
        ];

        $user = UserModel::create($data);

        // User Address
        $addressData = [
            'user_id'           => $user->id,
            'street_address'    => $request->street_address,
            'city'              => $request->city,
            'state'             => $request->state,
            'zip_code'          => $request->zip_code,
            'country'           => $request->country,
        ];

        $userAddress = UserAddressModel::create($addressData);

        if ($user && $userAddress) {
            return $this->result->created($user, __('messages.user_create_response'));
        }

        return $this->result->badRequest(__('messages.general_error_response'));
    }

    /**
     * For Updating single user.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = UserModel::find($id);

        if (! $user) {
            return $this->result->notFound();
        }

        $emergencyContact = [
            'full_name'     =>  $request->ec_full_name,
            'relationship'  =>  $request->ec_relationship,
            'phone_number'  =>  $request->ec_phone_number,
        ];

        // Check if admin trying to change the password
        if ($request->new_password != '') {
            // encrypt the password
            $newPassword = bcrypt($request->new_password);
            $user->password = $newPassword;
        }

        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->marital_status = $request->marital_status;
        $user->date_of_birth = $request->date_of_birth;
        $user->emergency_contact = json_encode($emergencyContact);
        $user->position_id = $request->position;
        $user->save();

        // Update User Address Model
        $userAddress = UserAddressModel::where('user_id', $user->id)->first();
        if (! empty($userAddress)) {
            $userAddress->street_address = $request->street_address;
            $userAddress->city = $request->city;
            $userAddress->state = $request->state;
            $userAddress->zip_code = $request->zip_code;
            $userAddress->country = $request->country;
            $userAddress->save();
        } else {
            // user address
            $userAddress = [
                'user_id'           => $user->id,
                'street_address'    => $request->street_address,
                'city'              => $request->city,
                'state'             => $request->state,
                'zip_code'          => $request->zip_code,
                'country'           => $request->country,
            ];

            UserAddressModel::create($userAddress);
        }

        if ($userAddress && $user) {
            return $this->result->success($user, __('messages.user_update_response'));
        }

        return $this->result->badRequest(__('messages.general_error_response'));
    }

    /**
     * For Removing single user.
     */
    public function destroy($id): JsonResponse
    {
        $user = UserModel::find($id);

        if (! $user) {
            return $this->result->notFound();
        }

        $user->delete();

        if ($user) {
            return $this->result->success($user, __('messages.user_delete_response'));
        }

        return $this->result->badRequest(__('messages.general_error_response'));
    }
}
