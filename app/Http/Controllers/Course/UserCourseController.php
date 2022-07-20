<?php

declare(strict_types=1);

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\UserCourse as UserCourseModel;
use App\Utilities\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCourseController extends Controller
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
     * For Fetching all Courses.
     */
    public function index(): JsonResponse
    {
        $courses = UserCourseModel::with(['user', 'course', 'course.courseCategory'])->filter('id', 'DESC');

        return $this->result->success($courses);
    }

    /**
     * For Fetching single user course with relation to courses and user.
     */
    public function get($id): JsonResponse
    {
        $course = UserCourseModel::find($id);

        if (! $course) {
            return $this->result->notFound();
        }

        $course = UserCourseModel::with(['user', 'course', 'course.courseCategory'])->find($id);

        return $this->result->success($course);
    }

    /**
     * For Subscribing Course of user.
     */
    public function subscribe(Request $request): JsonResponse
    {
        $user_id = $this->user->id;
        $course = new UserCourseModel([
            'user_id'      => $user_id,
            'course_id'    => $request->input('course_id'),
            'status'       => $request->input('status'),
            'grade_status' => $request->input('grade_status'),
        ]);

        $course->save();

        return $this->result->created($course, 'Successfully subscribed!');
    }

    /**
     * For Subscribing Course of user.
     */
    public function process(Request $request): JsonResponse
    {
        $course_id = $request->course_id;

        $course = UserCourseModel::find($course_id);

        if (! $course) {
            return $this->result->notFound();
        }

        $course->status = $request->status;
        $course->save();

        return $this->get($course_id);
    }
}
