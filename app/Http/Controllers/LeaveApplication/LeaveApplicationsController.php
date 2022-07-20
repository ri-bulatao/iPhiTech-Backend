<?php

declare(strict_types=1);

namespace App\Http\Controllers\LeaveApplication;

use App\Enums\LeaveApplicationStatusEnums as LeaveStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeaveApplicationSaveRequest;
use App\Models\LeaveApplication;
use App\Models\User;
use App\Utilities\Result;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;

class LeaveApplicationsController extends Controller
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
     * For fetching the leave application list.
     */
    public function index(): JsonResponse
    {
        $leave_applications = LeaveApplication::with('user')->get();

        return $this->result->success($leave_applications);
    }

    /**
     * For getting single Leave application form.
     *
     * @param int $id
     */
    public function get($id): JsonResponse
    {
        $leave_application = LeaveApplication::find($id);

        if (! $leave_application) {
            return $this->result->notFound();
        }

        return $this->result->success($leave_application);
    }

    /**
     * For saving the leave application.
     */
    public function store(LeaveApplicationSaveRequest $request): JsonResponse
    {
        $filed = Carbon::now();
        $user_id = $request->user_id;
        $type = $request->type;
        $from = $request->from;
        $to = $request->to;
        $reason = $request->reason;
        $status = LeaveStatus::PENDING;
        $offset_date = $request->offset_date ?? '';
        $offset_time = $request->offset_time ?? '';

        $user = User::find($user_id);

        if (! $user) {
            return $this->result->notFound();
        }

        $leave_application = LeaveApplication::create([
            'filed' => $filed,
            'user_id' => $user_id,
            'type' => $type,
            'from' => $from,
            'to' => $to,
            'reason' => $reason,
            'status' => $status,
            'offset_date' => $offset_date,
            'offset_time' => $offset_time,
        ]);

        if (! $leave_application) {
            return $this->result->exception();
        }

        return $this->result->created($leave_application, 'Leave Application created');
    }

    /**
     * For updating the leave application.
     *
     * @param int $id
     *
     * @return JosnResponse
     */
    public function update(LeaveApplicationSaveRequest $request, $id): JsonResponse
    {
        $filed = $request->filed;
        $user_id = $request->user_id;
        $type = $request->type;
        $from = $request->from;
        $to = $request->to;
        $reason = $request->reason;
        $status = $request->status;
        $comment = $request->comment;
        $offset_date = $request->offset_date ?? '';
        $offset_time = $request->offset_time ?? '';

        $leave_application = LeaveApplication::find($id);

        if (! $leave_application) {
            return $this->result->notFound();
        }

        $user = User::find($user_id);

        if (! $user) {
            return $this->result->notFound();
        }

        $leave_application->filed = $filed;
        $leave_application->user_id = $user_id;
        $leave_application->type = $type;
        $leave_application->from = $from;
        $leave_application->to = $to;
        $leave_application->reason = $reason;
        $leave_application->status = $status;
        $leave_application->comment = $comment;
        $leave_application->offset_date = $offset_date;
        $leave_application->offset_time = $offset_time;
        $leave_application->save();

        return $this->result->success($leave_application, 'Leave application updated');
    }

    /**
     * For deleting a leave application record.
     *
     * @param int $id
     */
    public function destroy($id): JsonResponse
    {
        $leave_application = LeaveApplication::find($id);

        if (! $leave_application) {
            return $this->result->notFound();
        }

        $deleted = $leave_application->delete();

        if (! $deleted) {
            return $this->result->exception();
        }

        return $this->result->success($deleted, 'Leave application deleted');
    }
}
