<?php
// Migration PostgreSQL - Création des index
return [
    "CREATE UNIQUE INDEX IF NOT EXISTS idx_unique_compte_principal 
     ON compte (client_id) 
     WHERE type = 'Principal'",
    
    "CREATE INDEX IF NOT EXISTS idx_transaction_date ON transaction(date)",
    "CREATE INDEX IF NOT EXISTS idx_transaction_type ON transaction(type)",
    "CREATE INDEX IF NOT EXISTS idx_compte_type ON compte(type)",
    "CREATE INDEX IF NOT EXISTS idx_utilisateur_profil ON utilisateur(profil_id)"
];