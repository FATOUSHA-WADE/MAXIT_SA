<?php
// Migration PostgreSQL - Création de la table transaction
return [
    "CREATE TABLE IF NOT EXISTS transaction (
        id SERIAL PRIMARY KEY,
        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        type VARCHAR(20) NOT NULL CHECK (type IN ('Retrait', 'Depot', 'Paiement')),
        montant DECIMAL(12,2) NOT NULL,
        compte_id INTEGER NOT NULL REFERENCES compte(id) ON DELETE CASCADE ON UPDATE CASCADE
        
    )"
];