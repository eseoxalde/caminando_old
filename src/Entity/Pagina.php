<?php

namespace App\Entity;

use App\Repository\PaginaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(targetEntity: Carpeta::class, inversedBy: 'paginas')]
    private ?Carpeta $carpeta = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $textoConLinks = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $slug = null;
    
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $ogTitle = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $ogDescription = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $ogImage = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $ogUrl = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $ogType = null;


    public function __construct()
    { }

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
    
    public function getCarpeta(): ?Carpeta
    {
        return $this->carpeta;
    }
    
    public function setCarpeta(?Carpeta $carpeta): self
    {
        $this->carpeta = $carpeta;
        return $this;
    }

    public function getTextoConLinks(): ?string
    {
        return $this->textoConLinks;
    }

    public function setTextoConLinks(?string $textoConLinks): static
    {
        $this->textoConLinks = $textoConLinks;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getOgTitle(): ?string
    {
        return $this->ogTitle;
    }

    public function setOgTitle(?string $ogTitle): self
    {
        $this->ogTitle = $ogTitle;
        return $this;
    }

    // Getter y Setter para ogDescription
    public function getOgDescription(): ?string
    {
        return $this->ogDescription;
    }

    public function setOgDescription(?string $ogDescription): self
    {
        $this->ogDescription = $ogDescription;
        return $this;
    }

    // Getter y Setter para ogImage
    public function getOgImage(): ?string
    {
        return $this->ogImage;
    }

    public function setOgImage(?string $ogImage): self
    {
        $this->ogImage = $ogImage;
        return $this;
    }

    // Getter y Setter para ogUrl
    public function getOgUrl(): ?string
    {
        return $this->ogUrl;
    }

    public function setOgUrl(?string $ogUrl): self
    {
        $this->ogUrl = $ogUrl;
        return $this;
    }

    // Getter y Setter para ogType
    public function getOgType(): ?string
    {
        return $this->ogType;
    }

    public function setOgType(?string $ogType): self
    {
        $this->ogType = $ogType;
        return $this;
    }

}
