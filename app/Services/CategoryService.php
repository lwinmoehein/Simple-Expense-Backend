<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Transaction;
use App\Repositories\CategoryRepository;

class  CategoryService {
    protected  $categoryRepository;

   public function __construct(CategoryRepository  $categoryRepository){
       $this->categoryRepository = $categoryRepository;
   }

   public function create($attributes):?Category{
       return $this->categoryRepository->create($attributes);
   }
    public function update(String $id,array $attributes):bool{
        $category = Category::find($id);

        if(!$category) return false;

        $isSameValuesAsOriginal = count(array_intersect($category->toArray(),$attributes))===count($attributes);

        if($isSameValuesAsOriginal) return false;

        $isUpdated =  $this->categoryRepository->update($id,$attributes);
        $versionIncreasedRows = Category::where('unique_id',$id)->increment('version',1);
        if($isUpdated && $versionIncreasedRows>0){
            return true;
        }
        return false;
    }
    public function deletedIds(){
        return $this->categoryRepository->getAllDeleted()->pluck('unique_id');
    }

   public function delete($id){
       $deletedCategoryCount = $this->categoryRepository->delete($id);
       if($deletedCategoryCount>0){
          $deletedTransactionsCount =  Transaction::where('category_id',$id)->delete();
          if($deletedCategoryCount>0) return true;
       }
       return false;
   }
}
