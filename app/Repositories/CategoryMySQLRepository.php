<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryMySQLRepository implements CategoryRepository {

    public function create(array $attributes): Category
    {
       return Category::updateOrCreate(["unique_id"=>$attributes["unique_id"]],$attributes);
    }
}
