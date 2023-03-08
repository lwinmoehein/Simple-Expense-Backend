<?php
namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;

class  CategoryService {
    protected  $categoryRepository;

   public function __construct(CategoryRepository  $categoryRepository){
       $this->categoryRepository = $categoryRepository;
   }

   public function create($attributes):Category{
       return $this->categoryRepository->create($attributes);
   }
}
