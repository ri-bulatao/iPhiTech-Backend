<?php

declare(strict_types=1);

namespace App\Http\Controllers;

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Models\Position as PositionModel;
use App\Utilities\Result;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
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
     * For Fetching all positions.
     */
    public function index(): JsonResponse
    {
        $this->authorize('position_show');

        $positions = PositionModel::filter('id', 'DESC');

        return $this->result->success($positions);
    }

    /**
     * For Fetching single position.
     */
    public function get($id): JsonResponse
    {
        $this->authorize('position_show');

        $position = PositionModel::find($id);

        return $this->result->success($position);
    }

    /**
     * For Storing new position.
     */
    public function store(PositionRequest $request): JsonResponse
    {
        $this->authorize('position_create');

        $position = new PositionModel(['name' => $request->input('name')]);
        $position->save();

        return $this->result->created($position, 'Position created!');
    }

    /**
     * For Updating single position.
     */
    public function update(PositionRequest $request, $id): JsonResponse
    {
        $this->authorize('position_edit');

        $position = PositionModel::find($id);

        if( ! $position ) {
            return $this->result->notFound();
        }

        $position->update($request->all());

        return $this->result->success($request, 'Position updated!');
    }

    /**
     * For Removing single position.
     */
    public function destroy($id): JsonResponse
    {
        $this->authorize('position_delete');

        $position = PositionModel::find($id);

        if( ! $position ) {
            return $this->result->notFound();
        }
        
        $position->delete();

        return $this->result->success($position, 'Position deleted!');
    }
}
