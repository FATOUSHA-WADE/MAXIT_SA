<?php

namespace App\Entities;

use App\Core\Abstract\AbstractEntity;

class Transaction extends AbstractEntity
{
    private int $id;
    private float $montant;
    private string $type; // 'Retrait', 'Depot', 'Paiement'
    private \DateTime $date;
    private int $compteId;

    public function __construct(
        int $id = 0,
        float $montant = 0.0,
        string $type = '',
        \DateTime $date = null,
        int $compteId = 0
    ) {
        $this->id = $id;
        $this->montant = $montant;
        $this->type = $type;
        $this->date = $date ?? new \DateTime();
        $this->compteId = $compteId;
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getMontant(): float { return $this->montant; }
    public function getType(): string { return $this->type; }
    public function getDate(): \DateTime { return $this->date; }
    public function getCompteId(): int { return $this->compteId; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setMontant(float $montant): void { $this->montant = $montant; }
    public function setType(string $type): void { $this->type = $type; }
    public function setDate(\DateTime $date): void { $this->date = $date; }
    public function setCompteId(int $compteId): void { $this->compteId = $compteId; }

    public static function toObject(array $tableau): static
    {
        return new static(
            $tableau['id'] ?? 0,
            $tableau['montant'] ?? 0.0,
            $tableau['type'] ?? '',
            isset($tableau['date']) ? new \DateTime($tableau['date']) : new \DateTime(),
            $tableau['compte_id'] ?? 0
        );
    }

   
    public function toArray(Object $object): array
    {
        return [
            'id' => $this->id,
            'montant' => $this->montant,
            'type' => $this->type,
            'date' => $this->date->format('Y-m-d H:i:s'),
            'compte_id' => $this->compteId
        ];
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'Retrait' => 'Retrait de fonds',
            'Depot' => 'Dépôt de fonds',
            'Paiement' => 'Paiement',
            default => 'Transaction'
        };
    }

    public function getTypeIcon(): string
    {
        return match($this->type) {
            'Retrait' => 'bi-cash',
            'Depot' => 'bi-arrow-down-left',
            'Paiement' => 'bi-credit-card',
            default => 'bi-arrow-right'
        };
    }

    public function getTypeBadgeClass(): string
    {
        return match($this->type) {
            'Retrait' => 'badge-retrait',
            'Depot' => 'badge-reception',
            'Paiement' => 'badge-paiement',
            default => 'badge-paiement'
        };
    }

    public function getFormattedDate(): string
    {
        return $this->date->format('d M Y');
    }
}