<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    public function index() {
        $positions = Position::all()->toArray();
        return array_reverse($positions);
    }
    public function store(Request $request) {
        $position = new Position(['name' => $request->input('name')]);
        $position->save();
        return response()->json([
            "success" => true,
            "message" => "Position created!"
        ]);
    }
    public function show($id) {
        $position = Position::find($id);
        return response()->json($position);
    }
    public function update($id, Request $request) {
        $position = Position::find($id);
        $position->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Position updated!"
        ]);
    }
    public function destroy($id) {
        $position = Position::find($id);
        $position->delete();
        return response()->json([
            "success" => true,
            "message" => "Position deleted!"
        ]);
    }
}
