<?php

declare(strict_types=1);

namespace App\Http\Controllers;

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utilities\Result;
use Illuminate\Http\JsonResponse;
use App\Models\Attendance as AttendanceModel;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Requests\AttendanceRequest;
use App\Enums\AttendanceStatusEnums as AttendanceStatus;
use Carbon\Carbon;
use App\Models\User;
use App\Enums\RoleEnums as Roles;

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
     * Get attendance of the user for today
     * 
     * @param AttendanceRequest $request
     * 
     * @return JsonResponse
     */
    public function today(AttendanceRequest $request): JsonResponse
    {
        $id = $request->user_id;
        $today = Carbon::today()->toDateString();

        $user = User::find( $id );

        if( ! $user ) {
            return $this->result->custom(false, null, 'The user is not found', 404);
        }

        $attendance = AttendanceModel::where('user_id', $user->id)->where('date', $today)->first();
        
        if( $attendance ) {
            if( $attendance->time_in !== null ) {
                $attendance->time_in_pretty =  Carbon::parse($attendance->time_in)->diffForHumans();
            }
            if( $attendance->time_out !== null ) {
                $attendance->time_out_pretty = Carbon::parse($attendance->time_out)->diffForHumans();
            }
            
        }

        if( ! $attendance ) {
            return $this->result->custom(false, null, 'The Attendance is not found', 404);
        }

        return $this->result->success($attendance);

    }

    /**
     * Get attendance record of the employee
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function employee(Request $request): JsonResponse
    {
        $id = $request->user_id;

        $user = User::find($id);

        if( ! $user ) {
            return $this->result->notFound();
        }

        $attendances = AttendanceModel::where('user_id', $user->id)->get();

        foreach( $attendances as $attendance ) {
            if( $attendance->time_in !== null ) {
                $attendance->time_in = Carbon::parse( $attendance->time_in )->toTimeString();
            }
            else {
                $attendance->time_in = 'N/A';
            }

            if( $attendance->time_out !== null ) {
                $attendance->time_out = Carbon::parse( $attendance->time_out )->toTimeString();
            }
            else {
                $attendance->time_out = 'N/A';
            }
        }

        return $this->result->success( $attendances );

    }

    /**
     * Get attendance record by user id
     * 
     * @var Request $request
     * 
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $user_id = $request->id;

        $user = User::find( $user_id );

        if( ! $user ) {
            return $this->result->notFound();
        }

        $records = [];

        if($user->hasRole(Roles::ADMINISTRATOR)) {
            $records = User::with('attendances')->get();
        }
        else {
            $records = AttendanceModel::where('user_id', $user_id)->get();
        }

        foreach( $records as $record ) {
            if( $record->time_in !== null ) {
                $record->time_in = Carbon::parse($record->time_in)->toTimeString();
            }
            else {
                $record->time_in = 'N/A';
            }

            if( $record->time_out !== null ) {
                $record->time_out = Carbon::parse($record->time_out)->toTimeString();
            }
            else {
                $record->time_out = 'N/A';
            }
        }

        return $this->result->success($records);

    }

    /**
     * Signin for the today attendance
     * 
     * @param AttendanceRequest $request
     * 
     * @return JsonResponse
     */
    public function time_in( AttendanceRequest $request ): JsonResponse
    {
        $user_id = $request->user_id;
        $status = AttendanceStatus::PRESENT;
        $time_in = Carbon::now();
        $time_out = null;
        $today = Carbon::today()->toDateString();

        $user = User::find($request->user_id);

        if( ! $user ) {
            return $this->result->notFound();
        }

        $exists = AttendanceModel::where('user_id', $user_id)->where('date', $today)->first();

        \Log::info($today);

        if( $exists ) {
            return $this->result->validationError($exists, 'This user already time in for today');
        }

        $attendance = AttendanceModel::create([
            'user_id' => $user_id,
            'status' => $status,
            'time_in' => $time_in,
            'time_out' => $time_out,
            'date' => $today
        ]);

        if( ! $attendance ) {
            return $this->result->exception();
        }

        return $this->result->created($attendance, 'Attendance Created');
    }

    /**
     * For time out functionality of the employee
     * 
     * @param AttendanceRequest $request
     * 
     * @return JsonResponse
     */
    public function time_out( AttendanceRequest $request ): JsonResponse
    {
        $user_id = $request->user_id;
        $today = Carbon::today()->toDateString();

        $attendance = AttendanceModel::where('user_id', $user_id)->where('date', $today)->first();

        if( ! $attendance ) {
            return $this->result->notFound();
        }

        if( $attendance->time_out !== null ) {
            return $this->result->validationError($attendance, 'This user already time out for today');
        }

        $attendance->time_out = Carbon::now();
        $attendance->save();

        return $this->result->success($attendance, 'Attendance Updated');

    }

}
