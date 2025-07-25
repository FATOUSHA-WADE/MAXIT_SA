<?php
// Migration MySQL - Création de la table compte
return [
    "CREATE TABLE IF NOT EXISTS compte (
        id INT AUTO_INCREMENT PRIMARY KEY,
        telephone VARCHAR(20) UNIQUE NOT NULL,
        solde DECIMAL(12,2) DEFAULT 0.00 NOT NULL,
        type VARCHAR(20) NOT NULL,
        client_id INT NOT NULL,
        FOREIGN KEY (client_id) REFERENCES utilisateur(id) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT chk_compte_type CHECK (type IN ('Principal', 'Secondaire')),
        INDEX idx_compte_type (type),
        INDEX idx_compte_client (client_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];