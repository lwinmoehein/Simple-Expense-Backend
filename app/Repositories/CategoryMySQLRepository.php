<?php
namespace App\Repositories;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Arr;

class CategoryMySQLRepository implements CategoryRepository {

    public function create(array $attributes): Category
    {
       return Category::create($attributes);
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


    public function update(string $id, array $attributes): bool
    {
        $numberOfUpdatedRows = Category::where("unique_id",$id)->update($attributes);

        if($numberOfUpdatedRows>0) return  true;

        return false;
    }

    public function delete($id)
    {
      return  Category::where('unique_id',$id)->delete();
    }
}
