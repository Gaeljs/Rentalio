<?php

namespace App\Entity;

use App\Repository\LogementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogementRepository::class)]
class Logement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $complement = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 5)]
    private ?string $code_postal = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montant_loyer = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $charges = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '2')]
    private ?string $montant_depot_garantie = null;

    #[ORM\Column]
    private ?bool $gestion = null;

    #[ORM\ManyToOne(inversedBy: 'logements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agence $agence_id = null;

    #[ORM\OneToMany(mappedBy: 'logement_id', targetEntity: Contrat::class)]
    private Collection $contrats;

    public function __toString(): string
    {
        return $this->getAdresse();
    }

    public function __construct()
    {
        $this->contrats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function setComplement(?string $complement): self
    {
        $this->complement = $complement;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getMontantLoyer(): ?string
    {
        return $this->montant_loyer;
    }

    public function setMontantLoyer(string $montant_loyer): self
    {
        $this->montant_loyer = $montant_loyer;

        return $this;
    }

    public function getCharges(): ?string
    {
        return $this->charges;
    }

    public function setCharges(string $charges): self
    {
        $this->charges = $charges;

        return $this;
    }

    public function getMontantDepotGarantie(): ?string
    {
        return $this->montant_depot_garantie;
    }

    public function setMontantDepotGarantie(string $montant_depot_garantie): self
    {
        $this->montant_depot_garantie = $montant_depot_garantie;

        return $this;
    }

    public function isGestion(): ?bool
    {
        return $this->gestion;
    }

    public function setGestion(bool $gestion): self
    {
        $this->gestion = $gestion;

        return $this;
    }

    public function getAgenceId(): ?Agence
    {
        return $this->agence_id;
    }

    public function setAgenceId(?Agence $agence_id): self
    {
        $this->agence_id = $agence_id;

        return $this;
    }

    /**
     * @return Collection<int, Contrat>
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): self
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats->add($contrat);
            $contrat->setLogementId($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): self
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getLogementId() === $this) {
                $contrat->setLogementId(null);
            }
        }

        return $this;
    }
}
