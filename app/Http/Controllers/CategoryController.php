<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\CategoryInterface;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'position' => 'nullable|integer|min:1|max:3',
                'name' => 'required|string|min:2|max:255',
                'pretty_name' => 'nullable|string|min:2|max:255',
                'slug' => 'nullable|string|min:2|max:255',
                'icon_path' => 'nullable',
                'image_path' => 'nullable',
                'desc' => 'nullable|string|min:2',
                'tags' => 'nullable|string|min:2',
            ]);

            if (!$validate->fails()) {
                $category = $this->categoryRepository->create($request->all());
                return response()->json(['category' => $category], 200);
            } else {
                return response()->json(['error' => $validate->errors()->first()], 400);
            }
        } catch (QueryException $err) {
            return response()->json(['error' => $err], 400);
        }
    }

    public function list(Request $request)
    {
        $data = $this->categoryRepository->listAll();
        return response()->json(['data' => $data], 200);
    }
}
