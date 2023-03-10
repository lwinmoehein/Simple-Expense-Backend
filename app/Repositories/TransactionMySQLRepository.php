<?php
namespace App\Repositories;

use App\Models\Transaction;

class TransactionMySQLRepository implements  TransactionRepository{

    public function create(array $attributes): Transaction
    {
        return  Transaction::create($attributes);
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

    public function update(string $id, array $attributes): bool
    {
       $numberOfUpdatedRows = Transaction::where("unique_id",$id)->update($attributes);

       if($numberOfUpdatedRows>0) return  true;

       return false;
    }
}
