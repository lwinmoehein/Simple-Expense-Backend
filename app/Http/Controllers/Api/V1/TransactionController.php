<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\StoreTransaction;
use App\Http\Requests\UpdateCategory;
use App\Http\Requests\UpdateTransaction;
use App\Models\Category;
use App\Models\Transaction;
use App\Repositories\CategoryRepository;
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

    public function update(Transaction $transaction,UpdateTransaction  $request){
        $isUpdated = $this->transactionService->update($transaction->unique_id,$request->validated());
        if($isUpdated)
            return $this->respondNoContent();

        return $this->respondError("Cannot  update transaction.");
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

        return $this->respondError("Cannot get deleted transactions.");
    }
    public function destroy($id){
        $isDeleteSuccess = $this->transactionService->delete($id);
        if($isDeleteSuccess)
            return $this->respondNoContent();

        return $this->respondError("Cannot delete transaction.");
    }
}
