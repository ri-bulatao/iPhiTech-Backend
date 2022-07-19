<?php

declare(strict_types=1);

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course as CourseModel;
use App\Utilities\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;

class CourseController extends Controller
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

    public function upload(ImageRequest $request)
    {
        $file_path = 'https://no-image.jpg';

        if($request->file()){
            $file_name = time().'_'.$request->file->getClientOriginalName();
            $file_path = env('APP_URL') . '/course_featured_image' . '/' . $file_name;
            $file->move(public_path('course_featured_image'), $file_name);
        }

        return $this->result->success([
            'url'   => $request->file(),
        ]);
    }
    
    /**
     * For Fetching all Courses.
     */
    public function index(): JsonResponse
    {
        $courses = CourseModel::with(['courseCategory'])->filter('id', 'DESC');

        return $this->result->success($courses);
    }

    /**
     * For Fetching single course.
     */
    public function get($id): JsonResponse
    {
        $course = CourseModel::find($id);

        return $this->result->success($course);
    }

    /**
     * For Storing new course.
     */
    public function store(CourseRequest $request): JsonResponse
    {
        $course = new CourseModel([
            'user_id'               => $this->user->id,
            'course_category_id'    => $request->input('course_category_id'),
            'title'                 => $request->input('title'),
            'description'           => $request->input('description'),
            'video_url'             => $request->input('video_url'),
            'is_embed'              => $request->input('is_embed'),
            'embed_code'            => $request->input('embed_code'),
            'featured_image'        => $request->input('featured_image'),
        ]);
        $course->save();

        return $this->result->created($course, 'Course created!');
    }

    /**
     * For Updating single course.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $course = CourseModel::find($id);

        if (! $course) {
            return $this->result->notFound();
        }

        $course->update($request->all());

        return $this->result->success($request, 'Course updated!');
    }

    /**
     * For Removing single course.
     */
    public function destroy($id): JsonResponse
    {
        $course = CourseModel::find($id);

        if (! $course) {
            return $this->result->notFound();
        }

        $course->delete();

        return $this->result->success($course, 'Course deleted!');
    }
}
