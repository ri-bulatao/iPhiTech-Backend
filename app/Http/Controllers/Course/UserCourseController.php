<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\UserCourse as UserCourseModel;
use App\Models\User as UserModel;
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
     * For Subscribing Course of user.
     */
    public function subscribe(Request $request): JsonResponse
    {
        $course = new UserCourseModel([
            'user_id'      => $this->user->id,
            'course_id'    => $request->input('course_category_id'),
            'status'       => $request->input('title'),
            'grade_status' => $request->input('description')
        ]);

        $course->save();
        
        $user = UserModel::with(['position', 'courses'])->find($id);

        return $this->result->created($course, 'Successfully subscribed!');
    }
}
