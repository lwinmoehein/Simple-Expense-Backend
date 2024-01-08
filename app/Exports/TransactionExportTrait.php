<?php
namespace App\Exports;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

trait TransactionExportTrait{
    function getExportTransactionBaseQuery(): Builder
    {
        return DB::table('transactions')
            ->join('categories', 'transactions.category_id', '=', 'categories.unique_id')
            ->whereNull('transactions.deleted_at')
            ->whereNull('categories.deleted_at')
            ->select(
                'categories.name as category',
                DB::raw("CASE transactions.type WHEN 0 THEN '၀င်ငွေ' WHEN 1 THEN 'ထွက်ငွေ' ELSE '-' END as type"),
                'transactions.amount as amount',
                'transactions.note as note',
                'transactions.created_at as created_at'
            )
            ->orderBy('transactions.created_at');
    }
}
