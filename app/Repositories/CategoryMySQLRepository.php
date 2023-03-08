<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryMySQLRepository implements CategoryRepository {

    public function create(array $attributes): Category
    {
       return Category::create($attributes);
    }
}
