<?php
// Migration PostgreSQL - Création de la table utilisateur
return [
    "CREATE TABLE IF NOT EXISTS utilisateur (
        id SERIAL PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        prenom VARCHAR(100) NOT NULL,
        numero_cni VARCHAR(20) UNIQUE NOT NULL,
        photo_recto_cni VARCHAR(255) NOT NULL,
        photo_verso_cni VARCHAR(255) NOT NULL,
        profil_id INTEGER REFERENCES profil(id) ON DELETE SET NULL ON UPDATE CASCADE,
        password VARCHAR(255) NOT NULL
       
    )"
];