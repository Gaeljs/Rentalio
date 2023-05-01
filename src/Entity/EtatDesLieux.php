<?php

namespace App\Entity;

use App\Repository\EtatDesLieuxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatDesLieuxRepository::class)]
class EtatDesLieux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'date')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contrat $contrat_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 500)]
    private ?string $remarques = null;

    #[ORM\Column(length: 30)]
    private ?string $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContratId(): ?Contrat
    {
        return $this->contrat_id;
    }

    public function setContratId(?Contrat $contrat_id): self
    {
        $this->contrat_id = $contrat_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRemarques(): ?string
    {
        return $this->remarques;
    }

    public function setRemarques(string $remarques): self
    {
        $this->remarques = $remarques;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
