<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    public function index() {
        // $positions = Position::all()->toArray();
        // return array_reverse($positions);

        return response()->json([
            'positons' => 'test'
        ]);
    }
    public function store(Request $request) {
        $position = new Position(['name' => $request->input('name')]);
        $position->save();
        return response()->json('Position created!');
    }
    public function show($id) {
        $position = Position::find($id);
        return response()->json($position);
    }
    public function update($id, Request $request) {
        $position = Position::find($id);
        $position->update($request->all());
        return response()->json('Position updated!');
    }
    public function destroy($id) {
        $position = Position::find($id);
        $position->delete();
        return response()->json('Position deleted!');
    }
}
