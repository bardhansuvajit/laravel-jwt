<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryInterface {
    public function listAll(string $sort = "id", string $order = "desc")
    {
        return Category::all($order, $id);
    }

    public function findById(string $slug)
    {
        return Category::where('slug', $slug)->first();
    }

    public function findBySlug(string $slug)
    {
        return Category::where('slug', $slug)->first();
    }

    public function create(array $data)
    {
        return Category::where('slug', $slug)->first();
    }
}