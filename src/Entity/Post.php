<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection; 
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $author;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comentario::class)]
    private Collection $comentarios;

    #[ORM\ManyToOne(targetEntity: Categoria::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Categoria $categoria;

    #[ORM\Column(type: 'boolean')]
    private bool $isImportant = false;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: FavoritePost::class, orphanRemoval: true)]
    private Collection $favorites;

    public function __construct()
    {
        $this->comentarios = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->favorites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): static
    {
        $this->author = $author;
        return $this;
    }

    public function getComentarios(): Collection // Cambié a 'getComentarios'
    {
        return $this->comentarios;
    }

    public function addComentario(Comentario $comentario): static // Cambié a 'addComentario'
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios->add($comentario);
            $comentario->setPost($this); 
        }
        return $this;
    }

    public function removeComentario(Comentario $comentario): static // Cambié a 'removeComentario'
    {
        if ($this->comentarios->removeElement($comentario)) {
            if ($comentario->getPost() === $this) {
                $comentario->setPost(null);
            }
        }
        return $this;
    }

    public function getLastComentario(): ?Comentario // Cambié a 'getLastComentario'
    {
        return $this->comentarios->isEmpty() ? null : $this->comentarios->last();
    }

    public function getCategoria(): Categoria // Cambié a 'getCategoria'
    {
        return $this->categoria;
    }

    public function setCategoria(Categoria $categoria): static // Cambié a 'setCategoria'
    {
        $this->categoria = $categoria;
        return $this;
    }

    public function getComentariosCount(): int
    {
        return $this->comentarios->count();
    }

    public function getParticipantsCount(): int
    {
        $participants = [];
        
        foreach ($this->comentarios as $comentario) {
            $author = $comentario->getAuthor();
            if ($author && !in_array($author, $participants)) {
                $participants[] = $author;
            }
        }

        return count($participants);
    }

    public function getLastComentarioAt(): ?\DateTimeInterface
    {
        return $this->getLastComentario()?->getCreatedAt();
    }

    public function isImportant(): bool
    {
        return $this->isImportant;
    }

    public function setImportant(bool $isImportant): static
    {
        $this->isImportant = $isImportant;
        return $this;
    }

    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(FavoritePost $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setPost($this);
        }
        return $this;
    }

    public function removeFavorite(FavoritePost $favorite): static
    {
        if ($this->favorites->removeElement($favorite)) {
            if ($favorite->getPost() === $this) {
                $favorite->setPost(null);
            }
        }
        return $this;
    }

    public function isFavorite(User $user): bool // Método para comprobar si es favorito
    {
        foreach ($this->favorites as $favorite) {
            if ($favorite->getUser() === $user) {
                return true;
            }
        }
        return false;
    }
}
