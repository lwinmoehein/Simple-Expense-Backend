<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\StoreCategory;
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
}
