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
    public function __construct(TransactionRepository  $transactionRepository)
    {
        $this->transactionService = new TransactionService($transactionRepository);
    }


    /**
     * @OA\Post(
     *     path="/api/transactions",
     *     summary="Add or update transaction",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="unique_id",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="amount",
     *                     type="integer"
     *                 ),
     *                  @OA\Property(
     *                     property="note",
     *                     type="string"
     *                 ),
     *                 example={"unique_id": "a3fb6", "amount": 100,"note":"hello"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function store(StoreTransaction $request){
        $transaction = $this->transactionService->create($request->validated());
        if($transaction)
            return $this->respondWithSuccess(["data"=>[
                "transaction"=>$transaction
            ]]);

        return $this->respondError("Cannot create or update transaction.");
    }
}
