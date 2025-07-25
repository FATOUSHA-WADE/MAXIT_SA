<?php

namespace App\Repositories;

use App\Entities\Transaction;
use App\Core\Abstract\AbstractRepository;
use PDO;
use PDOException;

class TransactionRepository extends AbstractRepository
{
    private static ?TransactionRepository $instance = null;
    
    private function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): TransactionRepository
    {
        if (is_null(self::$instance)) {
            self::$instance = new TransactionRepository();
        }
        return self::$instance;
    }

    public function selectAll()
    {
        // Implementation pour sélectionner toutes les transactions
    }

    public function insert(Transaction $transaction): int
    {
        $sql = "INSERT INTO transaction (montant, type, compte_id) 
                VALUES (:montant, :type, :compte_id)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':montant' => $transaction->getMontant(),
            ':type' => $transaction->getType(),
            ':compte_id' => $transaction->getCompteId()
        ]);
        
        return $this->db->lastInsertId();
    }

    public function update()
    {
        // Implementation pour mettre à jour une transaction
    }

    public function delete()
    {
        // Implementation pour supprimer une transaction
    }

    public function selectById($id)
    {
        // Implementation pour sélectionner une transaction par ID
    }

    public function getLastTransactionsByCompte(int $compteId, int $limit = 10): array
    {
        try {
            $sql = "SELECT * FROM transaction 
                    WHERE compte_id = :compte_id 
                    ORDER BY date DESC 
                    LIMIT :limit";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':compte_id', $compteId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $transactions = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $transactions[] = Transaction::toObject($row);
            }
            
            return $transactions;

        } catch (PDOException $e) {
            error_log("Erreur dans getLastTransactionsByCompte: " . $e->getMessage());
            return [];
        }
    }

    public function getAllTransactionsByCompte(int $compteId): array
    {
        try {
            $sql = "SELECT * FROM transaction 
                    WHERE compte_id = :compte_id 
                    ORDER BY date DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':compte_id' => $compteId]);
            
            $transactions = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $transactions[] = Transaction::toObject($row);
            }
            
            return $transactions;

        } catch (PDOException $e) {
            error_log("Erreur dans getAllTransactionsByCompte: " . $e->getMessage());
            return [];
        }
    }
}