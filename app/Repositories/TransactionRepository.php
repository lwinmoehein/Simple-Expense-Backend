<?php
namespace  App\Repositories;

use App\Models\Transaction;
use Illuminate\Support\Collection;

interface TransactionRepository
{
    public function create(array $attributes): ?Transaction;
    public function update(String $id,array $attributes): bool;
    public function batchUpdateOrCreate(array $transactions):bool;
    public function getAll();
    public function delete($id);
    public function getAllDeleted();
    public function getTransactionsForExport(string $userId,string $start,string $end):Collection;
}
