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

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Adds a new category",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="unique_id",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 example={"unique_id": "a3fb6", "name": "Food"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function store(StoreCategory $request){
       $category = $this->categoryService->create($request->validated());
       if($category)
           return $this->respondWithSuccess(["data"=>[
               "category"=>$category
           ]]);

       return $this->respondError("Cannot create category.");
    }
}
