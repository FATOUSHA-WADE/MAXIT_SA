<?php

namespace App\Services;
use App\Repositories\UserRepository;
use App\Repositories\CompteRepository;
use App\Entities\User;
use App\Entities\Compte;
use App\Core\App;
use App\Core\DataBase;
use PDOException;
class SecurityService 
{

    private static ?SecurityService $instance = null;
    private UserRepository $userRepository;
    private CompteRepository $compteRepository;
    private \PDO $db;
    private function __construct()
    {
        $this->db = App::getDependencie('DataBase')->connect();
        $this->userRepository = App::getDependencie('UserRepository');
        $this->compteRepository = App::getDependencie('CompteRepository');
    }

    public static function getInstance(): SecurityService
    {
        if (is_null(self::$instance)) 
        {
            self::$instance = new SecurityService();
        }
        return self::$instance;
    }
    
    public  function register(User $user)
    {
       return  $this->userRepository->insert($user);
    }

   
     public function registerUserWithCompte(User $user, Compte $compte): int|false
    {
        try 
        {
            $this->db->beginTransaction();
            $userId = $this->userRepository->insert($user);
            if (!$userId) 
            {
                $this->db->rollBack();
                return false;
            }
            $user->setId($userId);
            $compte->setUser($user);
            
            $compteResult = $this->compteRepository->insert($compte);
            if (!$compteResult) 
            {
                $this->db->rollBack();
                return false;
            }
            
            $this->db->commit();
            return $userId;

        } catch (PDOException $e) 
        {
            $this->db->rollBack();
           
            error_log("Erreur registerUserWithCompte: " . $e->getMessage());
            return false;
        }
    }

   
    public function login(string $telephone, string $password)
    {
        $userData = $this->userRepository->findUser($telephone);
        
        if ($userData) 
        {
            $storedPassword = $userData['user']->getPassword();
           
            if (password_verify($password, $storedPassword)) 
            {
            
                return $userData;
                
            }
        }
        
        return null;
    }

}