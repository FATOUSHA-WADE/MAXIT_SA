<?php
namespace App\Repositories;

use App\Entities\Compte;
use App\Core\Abstract\AbstractRepository;
use App\Core\Abstract\AbstractEntity;
use PDO;

class CompteRepository extends AbstractRepository
{
    private static ?CompteRepository $instance = null;

    private function __construct()
    {
        parent::__construct();
    }
    
    public static function getInstance(): CompteRepository
    {
        if (is_null(self::$instance)) {
            self::$instance = new CompteRepository();
        }
        return self::$instance;
    }

    public function insert(Compte $compte): int
    {
        $sql = "INSERT INTO compte (telephone, solde, type, client_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $compte->getNumeroTelephone(),
            $compte->getSolde() ? $compte->getSolde() : 0.0,
            $compte->getTypeCompte(),
            $compte->getUser()->getId()
        ]);
        return $this->db->lastInsertId();
    }

    public function isNumeroTelephoneUnique(string $telephone): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM compte WHERE telephone = ?");
        $stmt->execute([$telephone]);
        return $stmt->fetchColumn() == 0;
    }

    public function getComptesByClientId(int $clientId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM compte WHERE client_id = ? ORDER BY type = 'Principal' DESC, id ASC");
        $stmt->execute([$clientId]);
        $comptes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comptes[] = $this->hydrate($row);
        }
        return $comptes;
    }
    /**
     * Récupérer le compte principal d'un client
     */
    public function getComptePrincipal(int $clientId): ?Compte
    {
        $stmt = $this->db->prepare("SELECT * FROM compte WHERE client_id = ? AND type = 'Principal'");
        $stmt->execute([$clientId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }
    /**
     * Récupérer les comptes secondaires d'un client
     */
    public function getComptesSecondaires(int $clientId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM compte WHERE client_id = ? AND type = 'Secondaire'");
        $stmt->execute([$clientId]);
        $comptes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comptes[] = $this->hydrate($row);
        }
        return $comptes;
    }
    /**
     * Sélectionner un compte par ID
     */
    public function selectById($id): ?Compte
    {
        $stmt = $this->db->prepare("SELECT * FROM compte WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }
    /**
     * Mettre à jour le solde d'un compte
     */
    public function updateSolde(int $compteId, float $nouveauSolde): bool
    {
        $stmt = $this->db->prepare("UPDATE compte SET solde = ? WHERE id = ?");
        return $stmt->execute([$nouveauSolde, $compteId]);
    }

    /**
     * Trouver un compte par numéro de téléphone
     */
    public function findByTelephone(string $telephone): ?Compte
    {
        $stmt = $this->db->prepare("SELECT * FROM compte WHERE telephone = ?");
        $stmt->execute([$telephone]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }

    /**
     * Définir un compte comme principal
     */
    public function setComptePrincipal(int $compteId, int $clientId): bool
    {
        try {
            $this->db->beginTransaction();
            
            // 1. Mettre tous les comptes du client en "Secondaire"
            $stmt1 = $this->db->prepare("UPDATE compte SET type = 'Secondaire' WHERE client_id = ?");
            $stmt1->execute([$clientId]);
            
            // 2. Mettre le compte sélectionné en "Principal"
            $stmt2 = $this->db->prepare("UPDATE compte SET type = 'Principal' WHERE id = ? AND client_id = ?");
            $result = $stmt2->execute([$compteId, $clientId]);
            
            $this->db->commit();
            return $result;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    /**
     * Hydrate un tableau de données en objet Compte
     */
    private function hydrate(array $data): Compte
    {
        $compte = new Compte($data['id'],$data['solde'], $data['type'], $data['telephone']);
        $compte->setId($data['id']);
        return $compte;
    }
    /**
     * Compter le nombre de comptes dans la base de données
     */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM compte");
        return (int) $stmt->fetchColumn();
    }
    
    public function selectAll() {}
    public function update() {}
    public function delete() {}
    public function isUnique(string $column, string $value): bool { return true; }
}