<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Utilities\Result;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @var Authenticatable
     */
    private $user;

    /**
     * @var Result
     */
    private $result;

    public function __construct(
        Result $result
    ) {
        $this->user = auth()->user();
        $this->result = $result;
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $this->validate($request, [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'gender' => 'required',
        ]);

        $user->update($request->only('first_name', 'middle_name', 'last_name', 'phone_number', 'email', 'gender', 'marital_status', 'date_of_birth'));

        $emergency_contact = [
            'full_name' =>  $request->ec_full_name,
            'relationship' =>  $request->ec_relationship,
            'phone_number' =>  $request->ec_phone_number,
        ];

        $user->emergency_contact = json_encode($emergency_contact);
        $user->save();

        return $this->result->success($user, __('user.update_successfully'));
    }
}
