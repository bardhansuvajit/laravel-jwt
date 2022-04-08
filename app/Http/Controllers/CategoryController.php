<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        try {
            $valicator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'pretty_name' => 'nullable|'
            ]);

        } catch (\Throwable $err) {
            return response()->json(['error' => $err], 400);
        }
    }
}
