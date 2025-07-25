<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Core\DataBase;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$driver = $_ENV['DB_DRIVER'];
$dbName = $_ENV['DB_NAME'];

try {
    $database = DataBase::getInstance();
    
    // Connexion sans DB pour créer la base si nécessaire
    $pdo = $database->connectWithoutDB();

    if ($driver === 'mysql') {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Base MySQL `$dbName` créée avec succès.\n";
        $pdo->exec("USE `$dbName`");
    } elseif ($driver === 'pgsql') {
        $check = $pdo->query("SELECT 1 FROM pg_database WHERE datname = '$dbName'")->fetch();
        if (!$check) {
            $pdo->exec("CREATE DATABASE \"$dbName\"");
            echo "Base PostgreSQL `$dbName` créée.\nRelancez la migration pour créer les tables.\n";
            writeEnvIfNotExists();
            exit;
        } else {
            echo "ℹ Base PostgreSQL `$dbName` déjà existante.\n";
        }
    }

    // Maintenant utiliser la connexion avec DB
    $pdo = $database->connect();

    // 1. Créer la table 'migrations' si elle n'existe pas
    $pdo->exec(
        $driver === 'mysql'
            ? "CREATE TABLE IF NOT EXISTS migrations (id INT AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255) NOT NULL, batch INT NOT NULL, migrated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)"
            : "CREATE TABLE IF NOT EXISTS migrations (id SERIAL PRIMARY KEY, migration VARCHAR(255) NOT NULL, batch INT NOT NULL, migrated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)"
    );

    // 2. Récupérer les migrations déjà appliquées
    $applied = [];
    $stmt = $pdo->query("SELECT migration FROM migrations");
    foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $mig) {
        $applied[$mig] = true;
    }

    // 3. Déterminer le dossier de migrations selon le driver
    $migrationsDir = __DIR__ . '/migrations/' . $driver;
    
    if (!is_dir($migrationsDir)) {
        throw new Exception("Le dossier de migrations '$migrationsDir' n'existe pas.");
    }
    
    echo " Utilisation du dossier : $migrationsDir\n";

    // 4. Lister les fichiers de migration spécifiques au driver
    $files = glob($migrationsDir . '/*.php');
    sort($files);
    
    if (empty($files)) {
        echo "  Aucun fichier de migration trouvé dans $migrationsDir\n";
        return;
    }
    
    $batch = (int)$pdo->query("SELECT COALESCE(MAX(batch),0)+1 FROM migrations")->fetchColumn();

    foreach ($files as $file) {
        $name = basename($file);
        if (isset($applied[$name])) {
            echo "- Migration déjà appliquée : $name\n";
            continue;
        }
        
        echo " Exécution de la migration : $name\n";
        $queries = include $file;
        
        if (!is_array($queries)) {
            throw new Exception("Le fichier $name doit retourner un tableau de requêtes SQL.");
        }
        
        foreach ($queries as $sql) {
            $pdo->exec($sql);
        }
        
        $pdo->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)")->execute([$name, $batch]);
        echo " Migration appliquée : $name\n";
    }

    echo "Toutes les migrations $driver ont été exécutées avec succès dans `$dbName`.\n";
    writeEnvIfNotExists();

} catch (Exception $e) {
    echo " Erreur : " . $e->getMessage() . "\n";
}

function writeEnvIfNotExists() {
    $envFile = __DIR__ . '/.env';
    if (!file_exists($envFile)) {
        $content = "DB_DRIVER={$_ENV['DB_DRIVER']}\n";
        $content .= "DB_HOST={$_ENV['DB_HOST']}\n";
        $content .= "DB_PORT={$_ENV['DB_PORT']}\n";
        $content .= "DB_USER={$_ENV['DB_USER']}\n";
        $content .= "DB_PASSWORD={$_ENV['DB_PASSWORD']}\n";
        $content .= "DB_NAME={$_ENV['DB_NAME']}\n";
        file_put_contents($envFile, $content);
        echo " Fichier .env créé avec la configuration de base de données.\n";
    }
}
