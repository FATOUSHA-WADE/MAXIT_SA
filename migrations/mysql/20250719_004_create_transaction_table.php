<?php
// Migration MySQL - Création de la table transaction
return [
    "CREATE TABLE IF NOT EXISTS transaction (
        id INT AUTO_INCREMENT PRIMARY KEY,
        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        type VARCHAR(20) NOT NULL,
        montant DECIMAL(12,2) NOT NULL,
        compte_id INT NOT NULL,
        FOREIGN KEY (compte_id) REFERENCES compte(id) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT chk_transaction_type CHECK (type IN ('Retrait', 'Depot', 'Paiement')),
        INDEX idx_transaction_date (date),
        INDEX idx_transaction_type (type),
        INDEX idx_transaction_compte (compte_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];