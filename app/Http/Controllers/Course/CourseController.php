<?php

declare(strict_types=1);

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\ImageRequest;
use App\Models\Course as CourseModel;
use App\Utilities\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function upload($file, $file_name)
    {
        $file->move(public_path('course_featured_image'), $file_name);
        $file_path = env('APP_URL') . '/course_featured_image' . '/' . $file_name;

        return $file_path;
    }

    /**
     * For Fetching all Courses.
     */
    public function index(): JsonResponse
    {
        $courses = CourseModel::with(['courseCategory', 'user', 'userCourse'])->filter('id', 'DESC');

        return $this->result->success($courses);
    }

    /**
     * For Fetching single course.
     */
    public function get($id): JsonResponse
    {
        $course = CourseModel::with(['courseCategory', 'user', 'userCourse'])->find($id);

        return $this->result->success($course);
    }

    /**
     * For Storing new course.
     */
    public function store(CourseRequest $request): JsonResponse
    {
        $path = 'https://dummyimage.com/600x400/595959/ffffff&text=No+Image';
        if ($request->file('featured_image')) {
            // Upload Featured Image File
            $file = $request->file('featured_image');
            $file_name = $request->file('featured_image')->hashName();

            $file_path = $this->upload($file, $file_name);

            $path = 'course_featured_image' . '/' . $file_name;
        }
        
        $course = new CourseModel([
            'user_id'               => $this->user->id,
            'course_category_id'    => $request->input('course_category_id'),
            'title'                 => $request->input('title'),
            'description'           => $request->input('description'),
            'video_url'             => $request->input('video_url'),
            'is_embed'              => $request->input('is_embed'),
            'embed_code'            => $request->input('embed_code'),
            'featured_image'        => $file_path,
        ]);

        $course->save();
        
        $course = CourseModel::with(['courseCategory'])->find($course->id);

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

        $course->course_category_id = $request->course_category_id;
        $course->title              = $request->title;
        $course->description        = $request->description;
        $course->video_url          = $request->video_url;
        $course->is_embed           = $request->is_embed;
        $course->embed_code         = $request->embed_code;

        if ($request->file('featured_image')) {
            // Upload Featured Image File
            $file = $request->file('featured_image');
            $file_name = $request->file('featured_image')->hashName();

            $file_path = $this->upload($file, $file_name);

            $course->featured_image = $file_path;
        }

        $course->save();

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
