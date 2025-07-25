<?php

namespace App\Services;

use App\Repositories\CompteRepository;
use App\Entities\Compte;
use App\Core\App;

class CompteService 
{
    private static ?CompteService $instance = null;
    private CompteRepository $compteRepository;

    private function __construct()
    {
        $this->compteRepository = App::getDependencie('CompteRepository');
    }

    public static function getInstance(): CompteService
    {
        if (is_null(self::$instance)) {
            self::$instance = new CompteService();
        }
        return self::$instance;
    }

    public function creerCompteSecondaire(Compte $compte): int
    {
        if (!$this->isNumeroTelephoneUnique($compte->getNumeroTelephone())) 
        {
            throw new \Exception("Ce numéro de téléphone existe déjà");
        }
        return $this->compteRepository->insert($compte);
   
    }

    public function getTousLesComptes(int $clientId): array
    {
        return $this->compteRepository->getComptesByClientId($clientId);
    }

    public function getComptePrincipal(int $clientId): ?Compte
    {
        return $this->compteRepository->getComptePrincipal($clientId);
    }

    public function getComptesSecondaires(int $clientId): array
    {
        return $this->compteRepository->getComptesSecondaires($clientId);
    }

    public function getCompteById(int $id): ?Compte
    {
        return $this->compteRepository->selectById($id);
    }

    public function updateSolde(int $compteId, float $nouveauSolde): bool
    {
        return $this->compteRepository->updateSolde($compteId, $nouveauSolde);
    }

    public function isNumeroTelephoneUnique(string $numeroTelephone): bool
    {
        return $this->compteRepository->isNumeroTelephoneUnique($numeroTelephone);
    }

    public function countComptes(): int
    {
        return $this->compteRepository->count();
    }

    /**
     * Définir un compte comme principal
     */
    public function definirComptePrincipal(int $compteId, int $clientId): bool
    {
        return $this->compteRepository->setComptePrincipal($compteId, $clientId);
    }

    /**
     * Trouver un compte par numéro de téléphone
     */
    public function getCompteByTelephone(string $telephone): ?Compte
    {
        return $this->compteRepository->findByTelephone($telephone);
    }
}