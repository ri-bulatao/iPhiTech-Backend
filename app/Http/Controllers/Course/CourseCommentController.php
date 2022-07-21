<?php

declare(strict_types=1);

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\CourseComment as CourseCommentModel;
use App\Utilities\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CourseCommentRequest;

class CourseCommentController extends Controller
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
     * For Storing new course comment.
     */
    public function store(CourseCommentRequest $request): JsonResponse
    {

        $course_comment = new CourseCommentModel([
            'user_id'           => $this->user->id,
            'course_id'         => $request->input('course_id'),
            'comment'           => $request->input('comment') 
        ]);

        $course_comment->save();

        $course_comment = CourseCommentModel::with(['user', 'course'])->find($course_comment->id);

        return $this->result->created($course_comment, 'Comment has been posted!');
    }

    /**
     * For Removing single comment.
     */
    public function destroy($id): JsonResponse
    {
        $course_comment = CourseCommentModel::find($id);

        if (! $course_comment) {
            return $this->result->notFound();
        }

        $course_comment->delete();

        return $this->result->success($course_comment, 'Course has been deleted!');
    }
}
