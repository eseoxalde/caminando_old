<?php

namespace App\Entity;

use App\Repository\ImagenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagenRepository::class)]
class Imagen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $altText = null;

    #[ORM\ManyToOne(targetEntity: Carpeta::class, inversedBy: 'imagenes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Carpeta $carpeta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getAltText(): ?string
    {
        return $this->altText;
    }

    public function setAltText(?string $altText): static
    {
        $this->altText = $altText;

        return $this;
    }

    public function setCarpeta(?Carpeta $carpeta): static
    {
        $this->carpeta = $carpeta;
        if ($carpeta !== null) {
            $this->pagina = null;
        }
        return $this;
    }

    public function getCarpeta(): ?Carpeta
    {
        return $this->carpeta;
    }

}
