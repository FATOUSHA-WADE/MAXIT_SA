<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Entities\Transaction;
use App\Core\App;

class TransactionService 
{
    private static ?TransactionService $instance = null;
    private TransactionRepository $transactionRepository;

    private function __construct()
    {
        $this->transactionRepository = App::getDependencie('TransactionRepository');
    }

    public static function getInstance(): TransactionService
    {
        if (is_null(self::$instance)) {
            self::$instance = new TransactionService();
        }
        return self::$instance;
    }

    public function getLastTransactions(int $compteId, int $limit = 10): array
    {
        return $this->transactionRepository->getLastTransactionsByCompte($compteId, $limit);
    }

    public function getAllTransactions(int $compteId): array
    {
        return $this->transactionRepository->getAllTransactionsByCompte($compteId);
    }

    public function createTransaction(Transaction $transaction): int
    {
        return $this->transactionRepository->insert($transaction);
    }
}