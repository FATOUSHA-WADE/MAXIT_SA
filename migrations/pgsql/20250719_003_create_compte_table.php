<?php
// Migration PostgreSQL - Création de la table compte
return [
    "CREATE TABLE IF NOT EXISTS compte (
        id SERIAL PRIMARY KEY,
        telephone VARCHAR(20) UNIQUE NOT NULL,
        solde DECIMAL(12,2) DEFAULT 0.00 NOT NULL,
        type VARCHAR(20) NOT NULL CHECK (type IN ('Principal', 'Secondaire')),
        client_id INTEGER NOT NULL REFERENCES utilisateur(id) ON DELETE CASCADE ON UPDATE CASCADE
        
    )"
];