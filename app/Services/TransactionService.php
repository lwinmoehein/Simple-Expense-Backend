<?php
namespace App\Services;

use App\Models\Transaction;
use App\Repositories\CategoryRepository;
use App\Repositories\TransactionRepository;

class  TransactionService {
    protected  $transactionRepository;
    protected $categoryRepository;

   public function __construct(TransactionRepository  $transactionRepository,CategoryRepository $categoryRepository){
       $this->transactionRepository = $transactionRepository;
       $this->categoryRepository = $categoryRepository;
   }

   public function create($attributes): ?Transaction{
       $category = $this->categoryRepository->find($attributes['category_id']);

       if(!$category) return null;

       $transaction =  $this->transactionRepository->create($attributes);
       $transaction->category_id = $category->unique_id;
       $transaction->save();

       return $transaction;
   }

    public function update(String $id,array $attributes):bool{
        return $this->transactionRepository->update($id,$attributes);
    }

   public function all(){
       return $this->transactionRepository->getAll();
   }
    public function deletedIds(){
        return $this->transactionRepository->getAllDeleted()->pluck('unique_id');
    }
    public function delete($id){
        $deletedTransactionCount = $this->transactionRepository->delete($id);

        if($deletedTransactionCount>0) return true;

        return false;
    }
}
