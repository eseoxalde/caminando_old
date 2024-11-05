<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ForoRepository;

#[ORM\Entity(repositoryClass: ForoRepository::class)]
class Foro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)] 
    private ?string $nombre = null;

    #[ORM\Column(type: 'text', nullable: true)] 
    private ?string $descripcion = null; 

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $postsNormalesLimit = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $postsImportantesLimit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPostsNormalesLimit(): ?int
    {
        return $this->postsNormalesLimit;
    }

    public function setPostsNormalesLimit(?int $postsNormalesLimit): self
    {
        $this->postsNormalesLimit = $postsNormalesLimit;

        return $this;
    }

    public function getPostsImportantesLimit(): ?int
    {
        return $this->postsImportantesLimit;
    }

    public function setPostsImportantesLimit(?int $postsImportantesLimit): self 
    {
        $this->postsImportantesLimit = $postsImportantesLimit;

        return $this;
    }
}
