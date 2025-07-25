<?php
// Migration MySQL - Création de la table profil
return [
    "CREATE TABLE IF NOT EXISTS profil (
        id INT AUTO_INCREMENT PRIMARY KEY,
        role VARCHAR(20) NOT NULL,
        CONSTRAINT chk_profil_role CHECK (role IN ('Client', 'Service Commercial'))
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];