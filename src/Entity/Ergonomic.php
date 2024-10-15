<?php

namespace App\Entity;

use App\Repository\ErgonomicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ErgonomicRepository::class)]
class Ergonomic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, RoomErgonomic>
     */
    #[ORM\OneToMany(targetEntity: RoomErgonomic::class, mappedBy: 'ergonomic')]
    private Collection $room_ergonomics;

    public function __construct()
    {
        $this->room_ergonomics = new ArrayCollection();
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
     * @return Collection<int, RoomErgonomic>
     */
    public function getRoomErgonomics(): Collection
    {
        return $this->room_ergonomics;
    }

    public function addRoomErgonomic(RoomErgonomic $roomErgonomic): static
    {
        if (!$this->room_ergonomics->contains($roomErgonomic)) {
            $this->room_ergonomics->add($roomErgonomic);
            $roomErgonomic->setErgonomic($this);
        }

        return $this;
    }

    public function removeRoomErgonomic(RoomErgonomic $roomErgonomic): static
    {
        if ($this->room_ergonomics->removeElement($roomErgonomic)) {
            // set the owning side to null (unless already changed)
            if ($roomErgonomic->getErgonomic() === $this) {
                $roomErgonomic->setErgonomic(null);
            }
        }

        return $this;
    }
}
