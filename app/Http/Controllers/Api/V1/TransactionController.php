<?php

namespace App\Http\Controllers\Api\V1;


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
     * @OA\POST(
     *     path="/api/get-access-token/{googleIdToken}",
     *     summary="Get app token by using google id token",
     *     @OA\Parameter(
     *         description="use google id token from firebase authentication.",
     *         in="path",
     *         name="googleIdToken",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="returns a sanctum token if successful."
     *     )
     * )
     */
    public function create(){

    }
}
