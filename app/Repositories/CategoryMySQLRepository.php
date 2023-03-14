<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryMySQLRepository implements CategoryRepository {

    public function create(array $attributes):?Category
    {
        try {
          return  Category::create($attributes);
        }catch (\Exception $exception){
          return null;

        }
        return null;
    }

    public function getAll()
    {
        return Category::withTrashed()->get();
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

    public function batchUpdateOrCreate(array $categories): bool
    {
       return Category::upsert($categories,['unique_id']);
    }
}
