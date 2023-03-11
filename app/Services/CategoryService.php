<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Transaction;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

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

        if($isUpdated){
            Category::where('unique_id',$id)->increment('version',1);
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
    public function getNewClientCategoryIds(array $versions): array
    {
        $allCategories = $this->categoryRepository->getAll()->toArray();
        $serverVersions = array_column($allCategories, 'unique_id');
        $clientVersions = array_keys($versions);

        return array_values(array_filter($clientVersions,function ($key) use ($serverVersions){
            return !in_array($key,$serverVersions);
        }));
    }
   public function getNewServerCategories(array $versions):Collection{
       $allCategories = $this->categoryRepository->getAll();

       return $allCategories->filter(function ($category) use ($versions) {
           return !isset($versions[$category->unique_id]);
       });
   }
    public function getToUpdateClientCategories(array $versions):Collection{
        $allCategories = $this->categoryRepository->getAll();

        return $allCategories->filter(function ($category) use ($versions) {
            return isset($versions[$category->unique_id]) && $category->version>=$versions[$category->unique_id];
        });
    }
    public function getToUpdateServerCategories(array $versions):Collection{
        $allCategories = $this->categoryRepository->getAll();

        return $allCategories->filter(function ($category) use ($versions) {
            return isset($versions[$category->unique_id]) && $category->version<$versions[$category->unique_id];
        });
    }
}
