<?php

namespace App\Repositories;
use App\Entities\User;
use App\Entities\Compte;
use App\Repositories\CompteRepository;
use App\Core\Abstract\AbstractRepository;
use App\Core\Abstract\AbstractEntity;
use App\Core\DataBase;
use App\Core\App;
use PDO;
use PDOException;

class UserRepository extends AbstractRepository
{
    private static ?UserRepository $userRepository = null;
    
    private function __construct()
    {
       parent::__construct();
    }

    public static function getInstance(): UserRepository
    {
        if (is_null(self::$userRepository)) {
            self::$userRepository = new UserRepository();
        }
        return self::$userRepository;
    }

    public function selectAll()
    {
        // Implementation for selecting all users
    }

    public function insert(User $utilisateur): int
    {
        if (!$utilisateur instanceof User) 
        {
            throw new \InvalidArgumentException('User attendu');
        }
        $sql= "INSERT INTO
         utilisateur 
        (nom,numero_cni,photo_recto_cni,photo_verso_cni, profil_id,prenom,password) 
        VALUES (:nom, :cni, :recto_cni, :verso_cni, :profil_id, :prenom,:password)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nom' => $utilisateur->getNom(),
            ':cni' => $utilisateur->getNumeroCni(),
            ':recto_cni' => $utilisateur->getPhotorecto(),
            ':verso_cni' => $utilisateur->getPhotoverso(),
            ':profil_id' => 1,
            ':prenom' => $utilisateur->getPrenom(),
            ':password' => $utilisateur->getPassword() 
        ]);
        return $this->db->lastInsertId();
    }

    public function update()
    {
        // Implementation for updating an existing user
    }

    public function delete()
    {
        // Implementation for deleting a user
    }

    public function selectById($id)
    {
        // Implementation for selecting a user by ID
    }

    public function findUser(string $numero): ?array
    {
        try {
            $sql = "SELECT u.id, u.nom, u.prenom, u.numero_cni, 
                       u.photo_recto_cni, u.photo_verso_cni, u.password,
                       c.id as compte_id, c.solde, c.type, c.telephone,
                       p.role 
                FROM utilisateur u
                JOIN compte c ON u.id = c.client_id
                JOIN profil p ON u.profil_id = p.id
                WHERE c.telephone = :telephone";
        
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':telephone' => $numero]);
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($data) {
       
                $userData = [
                    'id' => $data['id'],
                    'nom' => $data['nom'],
                    'prenom' => $data['prenom'],
                    'numero_cni' => $data['numero_cni'],
                    'photo_recto_cni' => $data['photo_recto_cni'],
                    'photo_verso_cni' => $data['photo_verso_cni'],
                    'role' => $data['role'],
                    'password' => $data['password'] 
                ];
                
                $compteData = [
                    'id' => $data['compte_id'],
                    'solde' => $data['solde'],
                    'type' => $data['type'],
                    'telephone' => $data['telephone']
                ];
                
                $user = User::toObject($userData);
                $compte = Compte::toObject($compteData);
                $compte->setUser($user); 
                
                return [
                    'user' => $user,
                    'compte' => $compte
                ];
            }
            
            return null;

        } catch (PDOException $e) {
            error_log("Erreur dans findUser: " . $e->getMessage());
            return null;
        }
    }

    public function isUnique(string $column, string $value): bool
    {
        $sql = "SELECT COUNT(*) FROM utilisateur WHERE $column = :value";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':value' => $value]);
        return $stmt->fetchColumn() == 0;
    }
}