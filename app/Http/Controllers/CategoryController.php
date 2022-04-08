<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'position' => 'integer|min:1|max:3',
                'name' => 'required|string|min:2|max:255',
                'pretty_name' => 'nullable|string|min:2|max:255',
                'slug' => 'nullable|string|min:2|max:255',
                'icon_path' => 'nullable',
                'image_path' => 'nullable',
                'desc' => 'nullable|string|min:2',
                'tags' => 'nullable|string|min:2',
            ]);

            if (!$validate->fails()) {
                // generate slug
                $slug = Str::slug($request->name, '-');
                $slugExistCount = Category::where('slug', $slug)->count();
                if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);

                $category = new Category();
                $category->name = $request->name;
                $category->pretty_name = $request->pretty_name ? $request->pretty_name : NULL;
                $category->slug = $slug;
                $category->save();
                return response()->json(['msg' => $category], 200);
            } else {
                return response()->json(['error' => $validate->errors()->first()], 400);
            }
        } catch (QueryException $err) {
            return response()->json(['error' => $err], 400);
        }
    }
}
