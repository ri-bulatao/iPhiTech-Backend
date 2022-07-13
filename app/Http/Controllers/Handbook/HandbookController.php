<?php

declare(strict_types=1);

namespace App\Http\Controllers\Handbook;

use App\Http\Controllers\Controller;
use App\Http\Requests\Handbook\HandbookRequest;
use App\Models\Handbook;
use App\Utilities\Result;
use File;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Response;

class HandbookController extends Controller
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
        $file->move(public_path('handbook'), $file_name);
        $file_path = env('APP_URL') . '/handbook' . '/' . $file_name;

        return $file_path;
    }

    /**
     * Download the handbook.
     */
    public function download($id)
    {
        $handbook = Handbook::find($id);

        if (! $handbook) {
            return $this->result->notFound();
        }

        $file_path = public_path($handbook->path);

        return Response::download($file_path);
    }

    /**
     * Fetch all the handbook versions.
     */
    public function index(): JsonResponse
    {
        $handbookVersions = Handbook::all();

        return $this->result->success($handbookVersions);
    }

    /**
     * Fetch Handbook.
     */
    public function get($id): JsonResponse
    {
        $handbook = Handbook::find($id);

        if (! $handbook) {
            return $this->result->notFound();
        }

        return $this->result->success($handbook);
    }

    /**
     * Store Handbook new version.
     *
     * ERROR on Request Validation
     */
    public function store(HandbookRequest $request): JsonResponse
    {

        // Upload PDF File
        $file = $request->file('book');
        $file_name = $request->file('book')->hashName();

        $file_path = $this->upload($file, $file_name);

        $path = 'handbook' . '/' . $file_name;

        $metadata = [
            'author' => $this->user,
        ];

        $data = [
            'version_name' => $request->version_name,
            'metadata' => $metadata,
            'pdf' => $file_path,
            'path' => $path,
        ];

        $handbook = Handbook::create($data);

        if ($handbook) {
            return $this->result->success($handbook, __('messages.handbook_create_response'));
        }

        return $this->result->badRequest(__('messages.general_error_response'));
    }

    /**
     * Update Handbook.
     */
    public function update(HandbookRequest $request, $id): JsonResponse
    {
        $handbook = Handbook::find($id);

        if (! $handbook) {
            return $this->result->notFound();
        }

        if ($request->file('book')) {
            // Upload PDF File
            $file = $request->file('book');
            $file_name = $request->file('book')->hashName();

            $file_path = $this->upload($file, $file_name);

            $handbook->pdf = $file_path;
        }

        $handbook->version_name = $request->version_name;
        $handbook->save();

        if ($handbook) {
            return $this->result->success($handbook, __('messages.handbook_update_response'));
        }

        return $this->result->badRequest(__('messages.general_error_response'));
    }

    /**
     * Delete Handbook.
     */
    public function destroy($id): JsonResponse
    {
        $handbook = Handbook::find($id);

        if (! $handbook) {
            return $this->result->notFound();
        }

        $handbook->delete();

        if ($handbook) {
            return $this->result->success($handbook, __('messages.handbook_delete_response'));
        }

        return $this->result->badRequest(__('messages.general_error_response'));
    }
}
