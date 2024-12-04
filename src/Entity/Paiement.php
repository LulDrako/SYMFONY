<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\Voiture;

#[ORM\Entity]
#[ORM\Table(name: 'paiements')]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'montant', type: 'decimal', precision: 10, scale: 2)]
    private float $montant;

    #[ORM\Column(name: 'methode_paiement', type: 'string', length: 255)]
    private string $methodePaiement;

    #[ORM\Column(name: 'statut', type: 'string', length: 50)]
    private string $statut;

    #[ORM\Column(name: 'numeroCarteBleu', type: 'string', length: 16)]
    private string $numeroCarteBleu;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Voiture::class)]
    #[ORM\JoinColumn(name: 'voiture_id', nullable: false)]
    private Voiture $voiture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;
        return $this;
    }

    public function getMethodePaiement(): string
    {
        return $this->methodePaiement;
    }

    public function setMethodePaiement(string $methodePaiement): self
    {
        $this->methodePaiement = $methodePaiement;
        return $this;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function getNumeroCarteBleu(): string
    {
        return $this->numeroCarteBleu;
    }

    public function setNumeroCarteBleu(string $numeroCarteBleu): self
    {
        $this->numeroCarteBleu = $numeroCarteBleu;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getVoiture(): Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(Voiture $voiture): self
    {
        $this->voiture = $voiture;
        return $this;
    }
}
