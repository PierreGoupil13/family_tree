<?php

namespace App\Entity;

use App\Repository\FamilyNodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilyNodeRepository::class)]
class FamilyNode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, FamilyMember>
     */
    #[ORM\ManyToMany(targetEntity: FamilyMember::class, inversedBy: 'parentOf')]
    private Collection $parents;

    /**
     * @var Collection<int, FamilyMember>
     */
    #[ORM\OneToMany(targetEntity: FamilyMember::class, mappedBy: 'childOf')]
    private Collection $children;

    public function __construct()
    {
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, FamilyMember>
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(FamilyMember $parent): static
    {
        if (!$this->parents->contains($parent)) {
            $this->parents->add($parent);
        }

        return $this;
    }

    public function removeParent(FamilyMember $parent): static
    {
        $this->parents->removeElement($parent);

        return $this;
    }

    /**
     * @return Collection<int, FamilyMember>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(FamilyMember $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setChildOf($this);
        }

        return $this;
    }

    public function removeChild(FamilyMember $child): static
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getChildOf() === $this) {
                $child->setChildOf(null);
            }
        }

        return $this;
    }
}
