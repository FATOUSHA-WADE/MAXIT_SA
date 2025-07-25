<?php
// Migration MySQL - Création de la table utilisateur
return [
    "CREATE TABLE IF NOT EXISTS utilisateur (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        prenom VARCHAR(100) NOT NULL,
        numero_cni VARCHAR(20) UNIQUE NOT NULL,
        photo_recto_cni VARCHAR(255) NOT NULL,
        photo_verso_cni VARCHAR(255) NOT NULL,
        profil_id INT,
        password VARCHAR(255) NOT NULL,
        FOREIGN KEY (profil_id) REFERENCES profil(id) ON DELETE SET NULL ON UPDATE CASCADE,
        INDEX idx_utilisateur_profil (profil_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];