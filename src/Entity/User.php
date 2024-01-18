<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]    
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 9, unique: true)]
    private ?string $matricule = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_connect = null;

    #[ORM\Column(length: 10, unique: true)]
    private ?string $pseudo = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'operateur', targetEntity: Contrat::class)]
    private Collection $contrats;

    #[ORM\OneToMany(mappedBy: 'operateur', targetEntity: FeuillePresence::class)]
    private Collection $feuillePresences;

    #[ORM\OneToMany(mappedBy: 'operateur', targetEntity: JustificationAbsence::class)]
    private Collection $justificationAbsences;

    public function __construct(){
        $this->createdAt= new \DateTimeImmutable();
        $this->contrats = new ArrayCollection();
        $this->feuillePresences = new ArrayCollection();
        $this->justificationAbsences = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNbConnect(): ?int
    {
        return $this->nb_connect;
    }

    public function setNbConnect(?int $nb_connect): static
    {
        $this->nb_connect = $nb_connect;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Contrat>
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): static
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats->add($contrat);
            $contrat->setOperateur($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): static
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getOperateur() === $this) {
                $contrat->setOperateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FeuillePresence>
     */
    public function getFeuillePresences(): Collection
    {
        return $this->feuillePresences;
    }

    public function addFeuillePresence(FeuillePresence $feuillePresence): static
    {
        if (!$this->feuillePresences->contains($feuillePresence)) {
            $this->feuillePresences->add($feuillePresence);
            $feuillePresence->setOperateur($this);
        }

        return $this;
    }

    public function removeFeuillePresence(FeuillePresence $feuillePresence): static
    {
        if ($this->feuillePresences->removeElement($feuillePresence)) {
            // set the owning side to null (unless already changed)
            if ($feuillePresence->getOperateur() === $this) {
                $feuillePresence->setOperateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JustificationAbsence>
     */
    public function getJustificationAbsences(): Collection
    {
        return $this->justificationAbsences;
    }

    public function addJustificationAbsence(JustificationAbsence $justificationAbsence): static
    {
        if (!$this->justificationAbsences->contains($justificationAbsence)) {
            $this->justificationAbsences->add($justificationAbsence);
            $justificationAbsence->setOperateur($this);
        }

        return $this;
    }

    public function removeJustificationAbsence(JustificationAbsence $justificationAbsence): static
    {
        if ($this->justificationAbsences->removeElement($justificationAbsence)) {
            // set the owning side to null (unless already changed)
            if ($justificationAbsence->getOperateur() === $this) {
                $justificationAbsence->setOperateur(null);
            }
        }

        return $this;
    }
}
