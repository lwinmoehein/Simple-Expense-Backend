<?php
namespace  App\Repositories;

use App\Models\Category;

interface CategoryRepository
{
    public function create(array $attributes):?Category;
    public function batchUpdateOrCreate(array $categories):bool;
    public function update(String $id,array $attributes): bool;
    public function getAll();
    public function delete($id);
    public function find($id);
    public function getAllDeleted();
}
