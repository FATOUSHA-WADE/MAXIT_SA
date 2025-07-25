-- Table Profil (rôles)
CREATE TABLE profil (
    id SERIAL PRIMARY KEY,
    role VARCHAR(20) NOT NULL CHECK (role IN ('Client', 'Service Commercial'))
);

-- Table Utilisateur
CREATE TABLE utilisateur (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    numero_cni VARCHAR(20) UNIQUE NOT NULL,
    photo_recto_cni VARCHAR(255) NOT NULL,
    photo_verso_cni VARCHAR(255) NOT NULL,
    profil_id INTEGER REFERENCES profil(id),
    password VARCHAR(255) NOT NULL,
   
);

-- Table Compte
CREATE TABLE compte (
    id SERIAL PRIMARY KEY,
    telephone VARCHAR(20) UNIQUE NOT NULL,
    solde DECIMAL(12,2) DEFAULT 0.00 NOT NULL,
    type VARCHAR(20) NOT NULL CHECK (type IN ('Principal', 'Secondaire')),
    client_id INTEGER NOT NULL REFERENCES utilisateur(id)

);

-- Table Transaction
CREATE TABLE transaction (
    id SERIAL PRIMARY KEY,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    type VARCHAR(20) NOT NULL CHECK (type IN ('Retrait', 'Depot', 'Paiement')),
    montant DECIMAL(12,2) NOT NULL,
    compte_id INTEGER NOT NULL REFERENCES compte(id)

);



CREATE UNIQUE INDEX idx_unique_compte_principal 
ON compte (client_id) 
WHERE type = 'Principal';