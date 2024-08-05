<?php

namespace App\Entity;

use App\Repository\CarpetaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarpetaRepository::class)]
class Carpeta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $descripcion = null;

    #[ORM\OneToMany(mappedBy: 'carpeta', targetEntity: Imagen::class, cascade: ['persist', 'remove'])]
    private Collection $imagenes;

    #[ORM\ManyToOne(targetEntity: Pagina::class, inversedBy: 'carpetas')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Pagina $pagina = null;

    public function __construct()
    {
        $this->imagenes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPagina(): ?Pagina
    {
        return $this->pagina;
    }

    public function setPagina(?Pagina $pagina): static
    {
        $this->pagina = $pagina;

        return $this;
    }

    public function getImagenes(): Collection
    {
        return $this->imagenes;
    }

    public function addImagen(Imagen $imagen): static
    {
        if (!$this->imagenes->contains($imagen)) {
            $this->imagenes->add($imagen);
            $imagen->setCarpeta($this);
        }

        return $this;
    }

    public function removeImagen(Imagen $imagen): static
    {
        if ($this->imagenes->removeElement($imagen)) {
            if ($imagen->getCarpeta() === $this) {
                $imagen->setCarpeta(null);
            }
        }

        return $this;
    }
}
