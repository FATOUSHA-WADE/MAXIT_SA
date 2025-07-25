<?php
namespace App\Entities;
use App\Core\Abstract\AbstractEntity;

class User extends AbstractEntity
{
    private int $id;
    private string $nom;
    private string $prenom;
    private string $numero_cni;
    private string $photorecto;
    private string $photoverso;
    private ?string $password = null;
    private Role $role;

    public function __construct(int $id=0, string $nom='', string $prenom ='',string $numero_cni='', string $photorecto='', string $photoverso='',string $password='', Role $role = null)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->numero_cni = $numero_cni;
        $this->photorecto = $photorecto ;
        $this->photoverso = $photoverso;
        $this->role = $role ?? new Role();
        $this->password = $password;
    }

    public function getId(): int{ return $this->id;}
    public function setId(int $id): void{$this->id = $id;}
    public function getNom(): string{return $this->nom;}
    public function setNom(string $nom): void{$this->nom = $nom;}
    public function getNumeroCni(): string{return $this->numero_cni;}
    public function setNumeroCni(string $numero_cni): void{$this->numero_cni = $numero_cni;}
    public function getPhotorecto(): string{return $this->photorecto;}
    public function setPhotorecto(string $photorecto): void{$this->photorecto = $photorecto;}
    public function getPhotoverso(): string{return $this->photoverso;}
    public function setPhotoverso(string $photoverso): void{$this->photoverso = $photoverso;}
    public function getRole(): Role{return $this->role;}
    public function setRole(Role $role): void{$this->role = $role;}
    public function getPrenom(): string{return $this->prenom;}
    public function setPrenom(string $prenom): void{$this->prenom = $prenom;}
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    
    public static function toObject(array $tableau): static
    {
        return new static(
            $tableau['id'] ?? 0,
            $tableau['nom'] ?? '',
            $tableau['prenom'] ?? '',
            $tableau['numero_cni'] ?? '',
            $tableau['photorecto'] ?? $tableau['photo_recto_cni'] ?? '', 
            $tableau['photoverso'] ?? $tableau['photo_verso_cni'] ?? '', 
            $tableau['password'] ?? '',
            isset($tableau['role']) && $tableau['role'] instanceof Role ? $tableau['role'] : null
        );
    }

    public function toArray(Object $object): array
    {
        return [
            'id' => $object->getId(),
            'nom' => $object->getNom(),
            'prenom' => $object->getPrenom(),
            'numero_cni' => $object->getNumeroCni(),
            'photorecto' => $object->getPhotorecto(),
            'photoverso' => $object->getPhotoverso(),
            'role' => $object->getRole()->getLibelle(),
            'password' => $object->getPassword()
        ];
    }
}