<?php

namespace App\Entity;

use App\Repository\SesionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

#[ORM\Entity(repositoryClass: SesionRepository::class)]
class Sesion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'datetime')]
    private $loginDate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $logoutDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getLoginDate(): ?\DateTimeInterface
    {
        return $this->loginDate;
    }

    public function setLoginDate(\DateTimeInterface $loginDate): static
    {
        $this->loginDate = $loginDate;

        return $this;
    }

    public function getLogoutDate(): ?\DateTimeInterface
    {
        return $this->logoutDate;
    }

    public function setLogoutDate(?\DateTimeInterface $logoutDate): static
    {
        $this->logoutDate = $logoutDate;

        return $this;
    }
}
