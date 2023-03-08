<?php
namespace App\Repositories;

use App\Models\Transaction;

class TransactionMySQLRepository implements  TransactionRepository{

    public function create(array $attributes): Transaction
    {
        return  Transaction::updateOrCreate(["unique_id"=>$attributes['unique_id']],$attributes);
    }
}
