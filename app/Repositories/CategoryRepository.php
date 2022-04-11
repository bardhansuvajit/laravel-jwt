<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryInterface {
    public function listAll(string $sort = "id", string $order = "desc")
    {
        return Category::orderBy($sort, $order)->get();
    }

    public function findById(int $id)
    {
        return Category::findOrFail($id);
    }

    public function findBySlug(string $slug)
    {
        return Category::where('slug', $slug)->first();
    }

    public function create(array $data)
    {
        try {
            $collection = collect($data);

            // generate slug
            $slug = Str::slug($collection['name'], '-');
            $slugExistCount = Category::where('name', $collection['name'])->count();
            if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);

            $category = new Category();
            $category->name = $collection['name'];
            $category->pretty_name = !empty($data->pretty_name) ? $collection['pretty_name'] : NULL;
            $category->slug = $slug;
            $resp = $category->save();
            return $collection;
        } catch (\Throwable $th) {
            return $th;
        }
    }
}