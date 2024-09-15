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

    #[ORM\OneToMany(mappedBy: 'carpeta', targetEntity: Pagina::class)]
    private Collection $paginas;

    public function __construct()
    {
        $this->imagenes = new ArrayCollection();
        $this->paginas = new ArrayCollection();
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

    public function getPaginas(): Collection
    {
        return $this->paginas;
    }

    public function addPagina(Pagina $pagina): self
    {
        if (!$this->paginas->contains($pagina)) {
            $this->paginas[] = $pagina;
            $pagina->setCarpeta($this);
        }

        return $this;
    }

    public function removePagina(Pagina $pagina): self
    {
        if ($this->paginas->removeElement($pagina)) {
            // Solo se elimina la relación bidireccional si la carpeta ya no está asociada a la página
            if ($pagina->getCarpeta() === $this) {
                $pagina->setCarpeta(null);
            }
        }

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
