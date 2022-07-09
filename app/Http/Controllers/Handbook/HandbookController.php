<?php

declare(strict_types=1);

namespace App\Http\Controllers\Handbook;

use App\Http\Controllers\Controller;
use App\Http\Requests\Handbook\HandbookRequest;
use App\Models\Handbook;
use App\Models\Handbook;
use App\Utilities\Result;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    /**
     * Fetch all the handbook versions.
     */
    public function index(Request $request): JsonResponse
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
        $metadata = [
            'author' => $this->user,
        ];

        $data = [
            'version_name' => $request->version_name,
            'metadata' => $metadata,
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
