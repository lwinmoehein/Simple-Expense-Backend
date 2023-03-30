<?php
namespace App\Repositories;

use App\Exports\TransactionExportTrait;
use App\Models\Transaction;
use Illuminate\Support\Collection;

class TransactionMySQLRepository implements  TransactionRepository{
    use TransactionExportTrait;

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

    public function getTransactionsForExport(string $type, int $month, int $year): Collection
    {
        switch ($type){
            case "monthly":
                return $this->getExportTransactionBaseQuery()->whereMonth("transactions.created_at",'=',$month)->whereYear("transactions.created_at",'=',$year)->get();
            case "yearly":
                return $this->getExportTransactionBaseQuery()->whereYear("transactions.created_at",'=',$year)->get();
            default:
                return $this->getExportTransactionBaseQuery()->get();
        }
    }
}
