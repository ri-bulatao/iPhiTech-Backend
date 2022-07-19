<?php

declare(strict_types=1);

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseCategoryRequest;
use App\Models\CourseCategory as CourseCategoryModel;
use App\Utilities\Result;
use Illuminate\Http\JsonResponse;

class CourseCategoryController extends Controller
{
    /**
     * @var Result
     */
    private $result;

    public function __construct(
        Result $result
    ) {
        $this->result = $result;
    }
    /**
     * For Fetching all CourseCategory.
     */
    public function index(): JsonResponse
    {
        $courseCategories = CourseCategoryModel::filter('id', 'DESC');

        return $this->result->success($courseCategories);
    }

    /**
     * For Fetching single courseCategory.
     */
    public function get($id): JsonResponse
    {
        $courseCategory = CourseCategoryModel::find($id);

        return $this->result->success($courseCategory);
    }

    /**
     * For Storing new courseCategory.
     */
    public function store(CourseCategoryRequest $request): JsonResponse
    {
        $courseCategory = new CourseCategoryModel(['title' => $request->input('title')]);
        $courseCategory->save();

        return $this->result->created($courseCategory, 'Course Category created!');
    }

    /**
     * For Updating single courseCategory.
     */
    public function update(CourseCategoryRequest $request, $id): JsonResponse
    {
        $courseCategory = CourseCategoryModel::find($id);

        if (! $courseCategory) {
            return $this->result->notFound();
        }

        $courseCategory->update($request->all());

        return $this->result->success($request, 'Course Category updated!');
    }

    /**
     * For Removing single courseCategory.
     */
    public function destroy($id): JsonResponse
    {
        $courseCategory = CourseCategoryModel::find($id);

        if (! $courseCategory) {
            return $this->result->notFound();
        }

        $courseCategory->delete();

        return $this->result->success($courseCategory, 'Course Category deleted!');
    }
}
