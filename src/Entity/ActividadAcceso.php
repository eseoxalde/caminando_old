<?php

namespace App\Entity;

use App\Repository\ActividadAccesoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActividadAccesoRepository::class)]
class ActividadAcceso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'datetime')]
    private $accessDate;

    #[ORM\Column(type: 'string', length: 255)]
    private $activity;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAccessDate(): ?\DateTimeInterface
    {
        return $this->accessDate;
    }

    public function setAccessDate(\DateTimeInterface $accessDate): self
    {
        $this->accessDate = $accessDate;

        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(string $activity): self
    {
        $this->activity = $activity;

        return $this;
    }
}
