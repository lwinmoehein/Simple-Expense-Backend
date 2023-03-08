<?php
namespace  App\Repositories;

use App\Models\Category;

interface CategoryRepository
{
    public function create(array $attributes): Category;
    public function getAll();
    public function delete($id);
    public function find($id);
}
