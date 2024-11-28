<?php

namespace App\Entity;

use App\Repository\SitioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SitioRepository::class)]
class Sitio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #El header es una imagen
    #[ORM\Column(type: Types::TEXT)]
    private ?string $header = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreSitio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logoSitio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagram = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facebook = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtube = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tiktok = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $metaTitle = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $metaDescription = null;

        // Título global para Open Graph
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $ogTitle = null;
    
        // Descripción global para Open Graph
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $ogDescription = null;
    
        // URL de la imagen global para Open Graph
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $ogImage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setHeader(string $header): static
    {
        $this->header = $header;

        return $this;
    }
    
    public function getFooter(): ?string
    {
        return $this->footer;
    }

    public function setFooter(string $footer): static
    {
        $this->footer = $footer;

        return $this;
    }

    public function getNombreSitio(): ?string
    {
        return $this->nombreSitio;
    }

    public function setNombreSitio(string $nombreSitio): static
    {
        $this->nombreSitio = $nombreSitio;

        return $this;
    }

    public function getLogoSitio(): ?string
    {
        return $this->logoSitio;
    }

    public function setLogoSitio(?string $logoSitio): static
    {
        $this->logoSitio = $logoSitio;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): static
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): static
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): static
    {
        $this->twitter = $twitter;

        return $this;
    }
    
    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): static
    {
        $this->youtube = $youtube;

        return $this;
    }

    public function getTiktok(): ?string
    {
        return $this->tiktok;
    }

    public function setTiktok(?string $tiktok): static
    {
        $this->tiktok = $tiktok;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(?string $metaTitle): self
    {
        $this->metaTitle = $metaTitle;
        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;
        return $this;
    }
    public function getOgTitle(): ?string { return $this->ogTitle; }
    public function setOgTitle(?string $ogTitle): self { $this->ogTitle = $ogTitle; return $this; }

    public function getOgDescription(): ?string { return $this->ogDescription; }
    public function setOgDescription(?string $ogDescription): self { $this->ogDescription = $ogDescription; return $this; }

    public function getOgImage(): ?string { return $this->ogImage; }
    public function setOgImage(?string $ogImage): self { $this->ogImage = $ogImage; return $this; }
   
}
