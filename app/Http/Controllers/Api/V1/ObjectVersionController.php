<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\GetChangedCategories;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;


class ObjectVersionController extends ApiController
{

    protected  $categoryService;

    public function __construct(CategoryRepository  $categoryRepository)
    {
        $this->categoryService = new CategoryService($categoryRepository);
    }

    public function getChangedCategories(GetChangedCategories  $request){
        try {
            $newServerCategories = $this->categoryService->getNewServerCategories($request->category_versions);
            $newClientCategoryIds= $this->categoryService->getNewClientCategoryIds($request->category_versions);
            $toUpdateClientCategories = $this->categoryService->getToUpdateClientCategories($request->category_versions);
            $toUpdateServerCategories = $this->categoryService->getToUpdateServerCategories($request->category_versions);

            return $this->respondWithSuccess(["data" => [
                "new_server_categories" => $newServerCategories,
                "new_client_category_ids" => $newClientCategoryIds,
                "categories_to_update_client" => $toUpdateClientCategories,
                "categories_to_update_server" => $toUpdateServerCategories
            ]]);
        }catch (\Exception $e){
            return $this->respondError("Cannot get changed categories.");
        }

        return $this->respondError("Cannot get changed categories.");
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
