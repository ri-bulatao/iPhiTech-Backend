<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Utilities\Result;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PasswordController extends Controller
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
     * Update the user's password.
     */
    public function update(Request $request): JsonResponse
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $user = $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return $this->result->success($user, __('user.update_successfully'));
    }
}
