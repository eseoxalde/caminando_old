<?php

namespace App\Entity;

use App\Repository\PaginaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaginaRepository::class)]
class Pagina
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: "paginas")]
    private ?Menu $menu = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $titulo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $subtitulo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $texto = null;

    #[ORM\Column(length: 100)]
    private ?string $ruta = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contenidoTipo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ruta_imagen_unica = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $texto_alt_imagen_unica = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ruta_video = null;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getSubtitulo(): ?string
    {
        return $this->subtitulo;
    }

    public function setSubtitulo(?string $subtitulo): static
    {
        $this->subtitulo = $subtitulo;

        return $this;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(?string $texto): static
    {
        $this->texto = $texto;

        return $this;
    }

    public function getRuta(): ?string
    {
        return $this->ruta;
    }

    public function setRuta(string $ruta): static
    {
        $this->ruta = $ruta;

        return $this;
    }

    public function getContenidoTipo(): ?string
    {
        return $this->contenidoTipo;
    }

    public function setContenidoTipo(?string $contenidoTipo): static
    {
        $this->contenidoTipo = $contenidoTipo;

        return $this;
    }

    public function getRutaImagenUnica(): ?string
    {
        return $this->ruta_imagen_unica;
    }

    public function setRutaImagenUnica(?string $ruta_imagen_unica): static
    {
        $this->ruta_imagen_unica = $ruta_imagen_unica;

        return $this;
    }

    public function getTextoAltImagenUnica(): ?string
    {
        return $this->texto_alt_imagen_unica;
    }

    public function setTextoAltImagenUnica(?string $texto_alt_imagen_unica): static
    {
        $this->texto_alt_imagen_unica = $texto_alt_imagen_unica;

        return $this;
    }

    public function getRutaVideo(): ?string
    {
        return $this->ruta_video;
    }

    public function setRutaVideo(?string $ruta_video): static
    {
        $this->ruta_video = $ruta_video;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): static
    {
        $this->menu = $menu;

        return $this;
}
}
