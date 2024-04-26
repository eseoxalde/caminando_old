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

    #[ORM\Column(type: Types::TEXT)]
    private ?string $titulo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $subtitulo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $texto = null;

    #[ORM\Column(length: 100)]
    private ?string $ruta = null;

    #[ORM\Column]
    private ?bool $imagen_tipo1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ruta_imagen_tipo1 = null;

    #[ORM\Column]
    private ?bool $video = null;

    #[ORM\Column(length: 255, nullable: true)]
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

    public function isImagenTipo1(): ?bool
    {
        return $this->imagen_tipo1;
    }

    public function setImagenTipo1(bool $imagen_tipo1): static
    {
        $this->imagen_tipo1 = $imagen_tipo1;

        return $this;
    }

    public function getRutaImagenTipo1(): ?string
    {
        return $this->ruta_imagen_tipo1;
    }

    public function setRutaImagenTipo1(?string $ruta_imagen_tipo1): static
    {
        $this->ruta_imagen_tipo1 = $ruta_imagen_tipo1;

        return $this;
    }

    public function isVideo(): ?bool
    {
        return $this->video;
    }

    public function setVideo(?bool $video): static
    {
        $this->video = $video;

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



}
