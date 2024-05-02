<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class FamilyMember
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    private ?string $lastName = null;

    /**
     * @var Collection<int, FamilyNode>
     */
    #[ORM\ManyToMany(targetEntity: FamilyNode::class, mappedBy: 'parents')]
    private Collection $parentOf;

    #[ORM\ManyToOne(inversedBy: 'children')]
    #[ORM\JoinColumn(nullable: true)]
    private ?FamilyNode $childOf = null;

    public function __construct()
    {
        $this->parentOf = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection<int, FamilyNode>
     */
    public function getParentOf(): Collection
    {
        return $this->parentOf;
    }

    public function addParentOf(FamilyNode $family): static
    {
        if (!$this->parentOf->contains($family)) {
            $this->parentOf->add($family);
            $family->addParent($this);
        }

        return $this;
    }

    public function removeParentOf(FamilyNode $family): static
    {
        if ($this->parentOf->removeElement($family)) {
            $family->removeParent($this);
        }

        return $this;
    }

    public function getChildOf(): ?FamilyNode
    {
        return $this->childOf;
    }

    public function setChildOf(?FamilyNode $childOf): static
    {
        $this->childOf = $childOf;

        return $this;
    }
}
