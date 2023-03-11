<?php
namespace App\Services;

use App\Models\Category;
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
       if($transaction) {
           $transaction->category_id = $category->unique_id;
           $transaction->save();
       }
       return $transaction;
   }

    public function update(String $id,array $attributes):bool{
        $category = Transaction::find($id);

        if(!$category) return false;

        $isSameValuesAsOriginal = count(array_intersect($category->toArray(),$attributes))===count($attributes);

        if($isSameValuesAsOriginal) return false;

        $isUpdated = $this->transactionRepository->update($id,$attributes);

        if($isUpdated){
            Transaction::where('unique_id',$id)->increment('version',1);
            return true;
        }
        return false;
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
