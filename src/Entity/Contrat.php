<?php

namespace App\Entity;

use App\Repository\ContratRepository;
use App\Repository\PaiementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContratRepository::class)]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    #[ORM\JoinColumn(name:'locataire_id', referencedColumnName: 'id', nullable: false)]
    private ?Locataire $locataire_id = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Logement $logement_id = null;

    #[ORM\OneToMany(mappedBy: 'contrat_id', targetEntity: Paiement::class)]
    private Collection $paiements;

    #[ORM\OneToMany(mappedBy: 'contrat_id', targetEntity: EtatDesLieux::class)]
    private Collection $etat_des_lieux;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_entree = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_sortie = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private  $solde = 0;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $archived = false;

    public function getArchived(): bool 
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function __construct()
    {
        $this->paiements = new ArrayCollection();
        $this->etat_des_lieux = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLocataireId(): ?Locataire
    {
        return $this->locataire_id;
    }

    public function setLocataireId(?Locataire $locataire): self
    {
        $this->locataire_id = $locataire;

        return $this;
    }

    public function getLogementId(): ?Logement
    {
        return $this->logement_id;
    }

    public function setLogementId(?Logement $logement_id): self
    {
        $this->logement_id = $logement_id;

        return $this;
    }

    /**
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): self
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setContratId($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getContratId() === $this) {
                $paiement->setContratId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatDesLieux>
     */
    public function getDate(): Collection
    {
        return $this->etat_des_lieux;
    }

    public function addDate(EtatDesLieux $date): self
    {
        if (!$this->etat_des_lieux->contains($date)) {
            $this->etat_des_lieux->add($date);
            $date->setContratId($this);
        }

        return $this;
    }

    public function removeDate(EtatDesLieux $date): self
    {
        if ($this->etat_des_lieux->removeElement($date)) {
            // set the owning side to null (unless already changed)
            if ($date->getContratId() === $this) {
                $date->setContratId(null);
            }
        }

        return $this;
    }

    public function getDateEntree(): ?\DateTimeInterface
    {
        return $this->date_entree;
    }

    public function setDateEntree(\DateTimeInterface $date_entree): self
    {
        $this->date_entree = $date_entree;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(\DateTimeInterface $date_sortie): self
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    public function getSolde(): ?string
    {
        return $this->solde;
    }

    public function setSolde(?string $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    public function isDepotDeGarantiePaid(): bool 
    {
        foreach ($this->paiements as $paiement) {
            if(!$paiement->getType()) {
                return true;
            }
        }
        return false;
    }


    public function addPaiementToSolde(Paiement $paiement): self
    {
        if ($paiement->getType() == true ) {
            $this->solde += $paiement->getMontant();
        } elseif($paiement->getType() == false) {
            $this->solde += $paiement->getMontant();
        }
        return $this;
    }

    public function isLoyerUpToDate(): bool
    {
        $currentMonth = (new \DateTime())->format('Y-m');
        foreach ($this->paiements as $paiement) {
            if ($paiement->getType() && $paiement->getDate()->format('Y-m') === $currentMonth) {
                return true;
            }
        }
        return false;
    }


}


