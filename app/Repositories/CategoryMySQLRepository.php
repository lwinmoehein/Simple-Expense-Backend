<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryMySQLRepository implements CategoryRepository {

    public function create($attributes): Category
    {
        dd($attributes);
       return Category::updateOrCreate(["unique_id"=>$attributes["unique_id"]],$attributes);
    }

    public function getAll()
    {
        return Category::all();
    }


    public function find($id)
    {
        return Category::find($id);
    }
    public function getAllDeleted()
    {
        return Category::onlyTrashed()->get();
    }

    public function delete($id)
    {
      return  Category::where('unique_id',$id)->delete();
    }
}
