<?php

declare(strict_types=1);

namespace App\Http\Controllers;

namespace App\Http\Controllers\Attendance;

use App\Enums\AttendanceStatusEnums as AttendanceStatus;
use App\Enums\RoleEnums as Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance as AttendanceModel;
use App\Models\User;
use App\Utilities\Result;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendancesController extends Controller
{
    /**
     * @var Authenticatable
     */
    private $user;

    /**
     * @var JsonResponse
     */
    private $result;

    public function __construct(Result $result)
    {
        $this->user = auth()->user();
        $this->result = $result;
    }

    /**
     * Get attendance of the user for today.
     */
    public function today(AttendanceRequest $request): JsonResponse
    {
        $id = $request->user_id;
        $today = Carbon::today()->toDateString();

        $user = User::find($id);

        if (! $user) {
            return $this->result->custom(false, null, 'The user is not found', 404);
        }

        $attendance = AttendanceModel::where('user_id', $user->id)->where('date', $today)->first();

        if ($attendance) {
            $attendance->time_in_pretty = Carbon::parse($attendance->time_in)->diffForHumans();
            $attendance->time_out_pretty = Carbon::parse($attendance->time_out)->diffForHumans();
        }

        if (! $attendance) {
            return $this->result->custom(false, null, 'The Attendance is not found', 404);
        }

        return $this->result->success($attendance);
    }

    /**
     * Get attendance record by user id.
     *
     * @var Request
     */
    public function index(Request $request): JsonResponse
    {
        $user_id = $request->id;
        \Log::info($user_id);
        $user = User::find($user_id);

        if (! $user) {
            return $this->result->notFound();
        }

        $records = [];

        if ($user->hasRole(Roles::ADMINISTRATOR)) {
            $records = User::with('attendances')->get();
        } else {
            $records = AttendanceModel::where('user_id', $user_id)->get();
        }

        return $this->result->success($records);
    }

    /**
     * Signin for the today attendance.
     */
    public function time_in(AttendanceRequest $request): JsonResponse
    {
        $user_id = $request->user_id;
        $status = AttendanceStatus::PRESENT;
        $time_in = Carbon::now();
        $time_out = null;
        $today = Carbon::today()->toDateString();

        $user = User::find($request->user_id);

        if (! $user) {
            return $this->result->notFound();
        }

        $exists = AttendanceModel::where('user_id', $user_id)->where('date', $today)->first();

        \Log::info($today);

        if ($exists) {
            return $this->result->validationError($exists, 'This user already time in for today');
        }

        $attendance = AttendanceModel::create([
            'user_id' => $user_id,
            'status' => $status,
            'time_in' => $time_in,
            'time_out' => $time_out,
            'date' => $today,
        ]);

        if (! $attendance) {
            return $this->result->exception();
        }

        return $this->result->created($attendance, 'Attendance Created');
    }

    /**
     * For time out functionality of the employee.
     */
    public function time_out(AttendanceRequest $request): JsonResponse
    {
        $user_id = $request->user_id;
        $today = Carbon::today()->toDateString();

        $attendance = AttendanceModel::where('user_id', $user_id)->where('date', $today)->first();

        if (! $attendance) {
            return $this->result->notFound();
        }

        if ($attendance->time_out !== null) {
            return $this->result->validationError($attendance, 'This user already time out for today');
        }

        $attendance->time_out = Carbon::now();
        $attendance->save();

        return $this->result->success($attendance, 'Attendance Updated');
    }
}
