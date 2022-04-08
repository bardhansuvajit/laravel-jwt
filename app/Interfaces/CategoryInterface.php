<?php

namespace App\Interfaces;

interface CategoryInterface {
    public function listAll(string $sort = "id", string $order = "desc");

    public function findById(int $id);

    public function findBySlug(string $slug);

    public function create(array $data);
}