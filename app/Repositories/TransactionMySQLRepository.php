<?php
namespace App\Repositories;

use App\Models\Transaction;

class TransactionMySQLRepository implements  TransactionRepository{

    public function create($attributes): Transaction
    {
        return  Transaction::updateOrCreate(["unique_id"=>$attributes['unique_id']],$attributes);
    }

    public function getAll()
    {
        return Transaction::all();
    }

    public function getAllDeleted()
    {
       return Transaction::onlyTrashed()->get();
    }
    public function delete($id)
    {
        return  Transaction::where('unique_id',$id)->delete();
    }
}
