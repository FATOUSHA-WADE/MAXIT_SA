<?php
namespace App\Entities;

use App\Core\Abstract\AbstractEntity;

class Compte extends AbstractEntity
{
    private int $id;
    private float $solde;
    private string $type_compte; 
    private string $numero_telephone;
    private User $user;

    public function __construct(
        int $id = 0,
        float $solde = 0.0,
        string $type_compte = 'Principal',
        string $numero_telephone = '',
    ) {
        $this->id = $id;
        $this->solde = $solde;
        $this->type_compte = $type_compte;
        $this->numero_telephone = $numero_telephone;
        $this->user = new User();
    }

    public function getId(): int { return $this->id; }

    public function getSolde(): float { return $this->solde; }
    public function getTypeCompte(): string { return $this->type_compte; }
    public function getNumeroTelephone(): string { return $this->numero_telephone; }
    
    public function getUser(): User { return $this->user; }
    public function setId(int $id): void { $this->id = $id; }
    public function setSolde(float $solde): void { $this->solde = $solde; }
    public function setTypeCompte(string $type): void { $this->type_compte = $type; }
    public function setNumeroTelephone(string $numero): void { $this->numero_telephone = $numero; }
    public function setUser(User $user): void { $this->user = $user; }

    public static function toObject(array $tableau): static
    {
        return new static(
            $tableau['id'] ?? 0,
            $tableau['solde'] ?? 0.0,
            $tableau['type'] ?? 'Principal',
            $tableau['telephone'] ?? ''
        );
    }

    public function toArray(Object $object): array
    {
        return [
            'id' => $object->getId(),
            'solde' => $object->getSolde(),
            'type_compte' => $object->getTypeCompte(),
            'numero_telephone' => $object->getNumeroTelephone(),
            'user_id' => $object->getUser()->getId()
        ];
    }
}