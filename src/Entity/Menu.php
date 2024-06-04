<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $ruta = null;

    #[ORM\Column]
    private ?bool $visible = null;

    #[ORM\Column]
    private ?int $posicion = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: "children")]
    #[ORM\JoinColumn(name: "parent_id", referencedColumnName: "id", onDelete: "SET NULL")]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: "parent", targetEntity: self::class)]
    private Collection $children;

    #[ORM\OneToMany(mappedBy: "menu", targetEntity: Pagina::class)]
    private Collection $paginas;

    public function __construct()
    {
        $this->children = new ArrayCollection();
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

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getRuta(): ?string
    {
        return $this->ruta;
    }

    public function setRuta(string $ruta): self
    {
        $this->ruta = $ruta;
        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;
        return $this;
    }

    public function getPosicion(): ?int
    {
        return $this->posicion;
    }

    public function setPosicion(int $posicion): self
    {
        $this->posicion = $posicion;
        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }
        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }
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
            $pagina->setMenu($this);
        }
        return $this;
    }

    public function removePagina(Pagina $pagina): self
    {
        if ($this->paginas->removeElement($pagina)) {
            if ($pagina->getMenu() === $this) {
                $pagina->setMenu(null);
            }
        }
        return $this;
    }

    public function getChildrenArray(?Menu $parent = null): array
    {
        $childrenArray = [];
        foreach ($this->children as $child) {
            if ($child->getParent() === $parent) {
                $childrenArray[] = $child;
            }
        }
        return $childrenArray;
    }

    public function setChildren(array $children): void
    {
        foreach ($children as $child) {
            $this->addChild($child);
        }
    }

}
