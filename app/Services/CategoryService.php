<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

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

   public function createAndGetUserCategories(User $user){
       $isCategoriesAlreadySeeded = Category::where('user_id',$user->google_user_id)->get()->count();

       if($isCategoriesAlreadySeeded>0){
           return Category::where('user_id',$user->google_user_id)->get();
       }

       $expenseCategoryNames = [
           ['name'=>'Food & Drinks','icon_name'=>'food_and_drink','user_id'=>$user->google_user_id],
           ['name'=>'Shopping','icon_name'=>'shopping','user_id'=>$user->google_user_id],
           ['name'=>'Housing','icon_name'=>'housing','user_id'=>$user->google_user_id],
           ['name'=>'Travel','icon_name'=>'travel','user_id'=>$user->google_user_id],
           ['name'=>'Vehicles','icon_name'=>'vehicles','user_id'=>$user->google_user_id],
           ['name'=>'Life & Entertainment','icon_name'=>'life_and_entertainment','user_id'=>$user->google_user_id],
           ['name'=>'IT Devices','icon_name'=>'it_devices','user_id'=>$user->google_user_id],
           ['name'=>'Health','icon_name'=>'health','user_id'=>$user->google_user_id],
           ['name'=>'Donation','icon_name'=>'donation','user_id'=>$user->google_user_id],
           ['name'=>'Other','icon_name'=>'other','user_id'=>$user->google_user_id]
       ];
       $incomeCategoryNames = [
           ['name'=>'Allowance','icon_name'=>'allowance','user_id'=>$user->google_user_id],
           ['name'=>'Salary','icon_name'=>'salary','user_id'=>$user->google_user_id],
           ['name'=>'Bonus','icon_name'=>'bonus','user_id'=>$user->google_user_id],
           ['name'=>'Other','icon_name'=>'other','user_id'=>$user->google_user_id]
       ];

       foreach ($expenseCategoryNames as $categoryName){
           Category::create([
               'name'=>$categoryName['name'],
               'icon_name'=>$categoryName['icon_name'],
               'user_id'=>$categoryName['user_id'],
               'unique_id'=>'expense_'.$user->google_user_id.Str::slug($categoryName['name']),
               'version'=>0,
               'is_default'=>true,
               'transaction_type'=>2,
               'created_at'=>now(),
               'updated_at'=>now()
           ]);
       }
       foreach ($incomeCategoryNames as $categoryName){
           Category::create([
               'name'=>$categoryName['name'],
               'icon_name'=>$categoryName['icon_name'],
               'user_id'=>$categoryName['user_id'],
               'unique_id'=>'income_'.$user->google_user_id.Str::slug($categoryName['name']),
               'version'=>0,
               'is_default'=>true,
               'transaction_type'=>1,
               'created_at'=>now(),
               'updated_at'=>now()
           ]);
       }

       return Category::where('user_id',$user->google_user_id)->get();
   }
}
