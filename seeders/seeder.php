<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\DataBase;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Fonction pour crypter les mots de passe
function hashPassword($plainPassword) {
    return password_hash($plainPassword, PASSWORD_DEFAULT);
}

$users = [
    [
        'nom' => 'John ',
        'prenom' => 'Doe',
        'numero_cni' => 'CNI123456',
        'photo_recto_cni' => 'recto1.png',
        'photo_verso_cni' => 'verso1.png',
        'profil_id' => 1,
        'password' => 'password1'
    ],
    [
        'nom' => 'Jane ',
        'prenom' => 'Smith',
        'numero_cni' => 'CNI654321',
        'photo_recto_cni' => 'recto2.png',
        'photo_verso_cni' => 'verso2.png',
        'profil_id' => 2,
        'password' => 'password2'
    ]
];

try {
    $database = DataBase::getInstance();
    $pdo = $database->connect();

    // Seed Profil
    $pdo->exec("INSERT INTO profil (role) VALUES ('Client'), ('Service Commercial') ON CONFLICT DO NOTHING;");

    // Seed Utilisateur avec mots de passe cryptés
    $stmt = $pdo->prepare("INSERT INTO utilisateur (nom,prenom, numero_cni, photo_recto_cni, photo_verso_cni, profil_id, password) VALUES (?,?, ?, ?, ?, ?, ?) ON CONFLICT DO NOTHING;");
    
    foreach ($users as $user) {
        $hashedPassword = hashPassword($user['password']);
        $stmt->execute([
            $user['nom'],
            $user['prenom'],
            $user['numero_cni'],
            $user['photo_recto_cni'],
            $user['photo_verso_cni'],
            $user['profil_id'],
            $hashedPassword
        ]);
    }

    // Seed Compte
    $pdo->exec("INSERT INTO compte (telephone, solde, type, client_id) VALUES
        ('770000001', 10000.00, 'Principal', 1),
        ('770000002', 5000.00, 'Secondaire', 1),
        ('770000003', 15000.00, 'Principal', 2)
        ON CONFLICT DO NOTHING;");

    // Seed Transaction
    $pdo->exec("INSERT INTO transaction (type, montant, compte_id) VALUES
        ('Depot', 5000.00, 1),
        ('Retrait', 2000.00, 2),
        ('Paiement', 1000.00, 1)
        ON CONFLICT DO NOTHING;");

    echo "Seeders exécutés avec succès !\n";
    echo "Mots de passe utilisés pour les tests :\n";
    foreach ($users as $user) {
        echo "- {$user['nom']}: {$user['password']}\n";
    }
    
} catch (Exception $e) {
    echo "Erreur lors du seeding : " . $e->getMessage() . "\n";
}
