<?php
namespace  App\Repositories;

use App\Models\Transaction;

interface TransactionRepository
{
    public function create(array $attributes): Transaction;
}
