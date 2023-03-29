<?php
namespace App\Exports;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

trait TransactionExportTrait{
    function getBaseQuery(): Builder
    {
        return DB::table('transactions')
            ->join('categories', 'transactions.category_id', '=', 'categories.unique_id')
            ->select('categories.name as category','transactions.amount as amount','transactions.note as note','transactions.created_at as date')
            ->orderBy('transactions.created_at');
    }
}
