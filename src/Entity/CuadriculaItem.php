<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class CuadriculaItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:255)]
    private ?string $imagen = null;

    #[ORM\Column(type:"string", length:255)]
    private ?string $enlace = null;

    #[ORM\ManyToOne(targetEntity:Pagina::class, inversedBy:"cuadriculaItems")]
    #[ORM\JoinColumn(nullable:false)]
    private ?Pagina $pagina = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getEnlace(): ?string
    {
        return $this->enlace;
    }

    public function setEnlace(string $enlace): self
    {
        $this->enlace = $enlace;

        return $this;
    }

    public function getPagina(): ?Pagina
    {
        return $this->pagina;
    }

    public function setPagina(?Pagina $pagina): self
    {
        $this->pagina = $pagina;

        return $this;
    }
}
