<?php

declare(strict_types=1);

namespace App\Http\Controllers\Handbook;

use App\Http\Controllers\Controller;
use App\Models\HandbookPage as HandbookPageModel;
use App\Utilities\Result;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HandbookPageController extends Controller
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
     * Fetch Handbook Page by selected hadbook (version).
     */
    public function get($id): JsonResponse
    {
        $handbook_page = HandbookPageModel::where('handbook_id', $id)->get();

        if (! $handbook_page) {
            return $this->result->notFound();
        }

        return $this->result->success($handbook_page);
    }

    /**
     * Fetch Handbook Page by selected hadbook page.
     */
    public function show($id): JsonResponse
    {
        $handbook_page = HandbookPageModel::where('id', $id)->first();

        if (! $handbook_page) {
            return $this->result->notFound();
        }

        return $this->result->success($handbook_page);
    }

    /**
     * Store Handbook new page.
     *
     * ERROR on Request Validation
     */
    public function store(Request $request): JsonResponse
    {
        $data = [
            'handbook_id'   => $request->handbook_id,
            'title'         => $request->title,
            'content'       => $request->content,
        ];

        $handbookPage = HandbookPageModel::create($data);

        if ($handbookPage) {
            return $this->result->success($handbookPage, __('messages.handbook_create_response'));
        }

        return $this->result->badRequest(__('messages.general_error_response'));
    }

    /**
     * Update Handbook page.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $handbookPage = HandbookPageModel::find($id);

        if (! $handbookPage) {
            return $this->result->notFound();
        }

        $handbookPage->title = $request->title;
        $handbookPage->content = $request->content;
        $handbookPage->save();

        if ($handbookPage) {
            return $this->result->success($handbookPage, __('messages.handbook_update_response'));
        }

        return $this->result->badRequest(__('messages.general_error_response'));
    }

    /**
     * Delete Handbook Page.
     */
    public function destroy($id): JsonResponse
    {
        $handbookPage = HandbookPageModel::find($id);

        if (! $handbookPage) {
            return $this->result->notFound();
        }

        $handbookPage->delete();

        if ($handbookPage) {
            return $this->result->success($handbookPage, __('messages.handbook_delete_response'));
        }

        return $this->result->badRequest(__('messages.general_error_response'));
    }
}
