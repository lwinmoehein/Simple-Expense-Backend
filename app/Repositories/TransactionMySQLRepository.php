<?php
namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionMySQLRepository implements  TransactionRepository{

    public function create(array $attributes): ?Transaction
    {
        try {
            return  Transaction::create($attributes);
        }catch (\Exception $e){
            return null;
        }

        return null;
    }

    public function getAll()
    {
        return Transaction::withTrashed()->where("user_id",auth()->user()->google_user_id)->get();
    }

    public function getAllDeleted()
    {
       return Transaction::onlyTrashed()->where("user_id",auth()->user()->google_user_id)->get();
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

    public function batchUpdateOrCreate(array $transactions): bool
    {
        return Transaction::upsert($transactions,["unique_id"]);
    }

}
