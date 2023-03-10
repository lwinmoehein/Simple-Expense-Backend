<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;


class CategoryController extends ApiController
{

    protected  $categoryService;
    public function __construct(CategoryRepository  $categoryRepository)
    {
        $this->categoryService = new CategoryService($categoryRepository);
    }


    public function store(StoreCategory $request){
       $category = $this->categoryService->create($request->validated());
       if($category)
           return $this->respondWithSuccess(["data"=>[
               "category"=>$category
           ]]);

       return $this->respondError("Cannot create or update category.");
    }
    public function update(Category $category,UpdateCategory  $request){
        $isUpdated = $this->categoryService->update($category->unique_id,$request->validated());
        if($isUpdated)
            return $this->respondWithSuccess(["data"=>[
                "category"=>$category
            ]]);

        return $this->respondError("Cannot  update category.");
    }
    public function deletedCategories(){
        $transactionIds = $this->categoryService->deletedIds();
        if($transactionIds)
            return $this->respondWithSuccess(["data"=>[
                "deleted_category_ids"=>$transactionIds
            ]]);

        return $this->respondError("Cannot get deleted categories.");
    }

    public function destroy($id){
        $isDeleteSuccess = $this->categoryService->delete($id);
        if($isDeleteSuccess)
            return $this->respondNoContent();

        return $this->respondError("Cannot delete category.");
    }
}
