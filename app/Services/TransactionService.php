<?php
namespace App\Services;

use App\Models\Transaction;
use App\Repositories\TransactionRepository;

class  TransactionService {
    protected  $transactionRepository;

   public function __construct(TransactionRepository  $transactionRepository){
       $this->transactionRepository = $transactionRepository;
   }

   public function create($attributes):Transaction{
       return $this->transactionRepository->create($attributes);
   }
}
