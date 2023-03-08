<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\StoreCategory;
use App\Http\Requests\StoreTransaction;
use App\Repositories\CategoryRepository;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\TransactionService;

class TransactionController extends ApiController
{

    protected  $transactionService;
    public function __construct(TransactionRepository  $transactionRepository,CategoryRepository $categoryRepository)
    {
        $this->transactionService = new TransactionService($transactionRepository,$categoryRepository);
    }

    public function store(StoreTransaction $request){
        $transaction = $this->transactionService->create($request->validated());
        if($transaction)
            return $this->respondWithSuccess(["data"=>[
                "transaction"=>$transaction
            ]]);

        return $this->respondError("Cannot create or update transaction.");
    }
    public function index(){
        $transactions = $this->transactionService->all();
        if($transactions)
            return $this->respondWithSuccess(["data"=>[
                "transactions"=>$transactions
            ]]);

        return $this->respondError("Cannot get transactions.");
    }
    public function deletedTransactions(){
        $transactionIds = $this->transactionService->deletedIds();
        if($transactionIds)
            return $this->respondWithSuccess(["data"=>[
                "deleted_transaction_ids"=>$transactionIds
            ]]);

        return $this->respondError("Cannot get transactions.");
    }
}
