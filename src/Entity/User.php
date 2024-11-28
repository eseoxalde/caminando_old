<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Ya hau una cuenta con este mail')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50, nullable:True)]
    private ?string $username = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $nombreVisible = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apellido = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $apellidoVisible = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pais = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ciudad = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaNacimiento = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $fechaNacimientoVisible = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $foto = null;

    #[ORM\Column(nullable: true)]
    private ?bool $notificaciones = null;

/**
     * @var Collection<int, FavoritePost>|null
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: FavoritePost::class, orphanRemoval: true)]
    private Collection $favoritePosts;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $ultimoAcceso;


    public function __construct()
    {
        $this->favoritePosts = new ArrayCollection();
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
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): static
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(?string $pais): static
    {
        $this->pais = $pais;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(?string $ciudad): static
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): static
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): static
    {
        $this->foto = $foto;

        return $this;
    }

    public function isNotificaciones(): ?bool
    {
        return $this->notificaciones;
    }

    public function setNotificaciones(?bool $notificaciones): static
    {
        $this->notificaciones = $notificaciones;

        return $this;
    }

    public function getFavoritePosts(): Collection
    {
        return $this->favoritePosts;
    }

    public function addFavoritePost(FavoritePost $favoritePost): static
    {
        if (!$this->favoritePosts->contains($favoritePost)) {
            $this->favoritePosts->add($favoritePost);
            $favoritePost->setUser($this);
        }

        return $this;
    }

    public function removeFavoritePost(FavoritePost $favoritePost): static
    {
        if ($this->favoritePosts->removeElement($favoritePost)) {
            if ($favoritePost->getUser() === $this) {
                $favoritePost->setUser(null);
            }
        }

        return $this;
    }

    public function getUltimoAcceso(): ?\DateTimeInterface
    {
        return $this->ultimoAcceso;
    }

    public function setUltimoAcceso(\DateTimeInterface $fecha): self
    {
        $this->ultimoAcceso = $fecha;

        return $this;
    }

    public function getNombreVisible(): ?bool
    {
        return $this->nombreVisible;
    }

    public function setNombreVisible(?bool $nombreVisible): self
    {
        $this->nombreVisible = $nombreVisible;

        return $this;
    }

    public function getApellidoVisible(): ?bool
    {
        return $this->apellidoVisible;
    }

    public function setApellidoVisible(?bool $apellidoVisible): self
    {
        $this->apellidoVisible = $apellidoVisible;

        return $this;
    }

    public function getFechaNacimientoVisible(): ?bool
    {
        return $this->FechaNacimientoVisible;
    }

    public function setFechaNacimientoVisible(?bool $FechaNacimientoVisible): self
    {
        $this->FechaNacimientoVisible = $FechaNacimientoVisible;

        return $this;
    }

    
}
