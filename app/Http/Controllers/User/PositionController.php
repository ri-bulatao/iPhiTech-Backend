<?php

declare(strict_types=1);

namespace App\Http\Controllers;

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Utilities\Result;
use App\Models\Position as PositionModel;
use App\Http\Requests\User\PositionRequest;
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
        
        $positions = PositionModel::all()->toArray();

        return $this->result->success(array_reverse($positions));
    }

    /**
     * For Fetching single position.
     */
    public function get($id): JsonResponse
    {
        $announcement = PositionModel::find($id);

        return $this->result->success($announcement);
    }

    /**
     * For Storing new position.
     */
    public function store(PositionRequest $request): JsonResponse
    {
        $position = new PositionModel(['name' => $request->input('name')]);
        $position->save();

        return $this->result->created($position, 'Position created!');
    }

    /**
     * For Updating single position.
     */
    public function update($id, PositionRequest $request): JsonResponse
    {
        $position = PositionModel::find($id);
        $position->update($request->all());

        return $this->result->success($position, 'Position updated!');
    }

    /**
     * For Removing single position.
     */
    public function destroy($id): JsonResponse
    {
        $position = PositionModel::find($id);
        $position->delete();

        return $this->result->success($position, 'Position deleted!');
    }
}
