<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, RoomEquipment>
     */
    #[ORM\OneToMany(targetEntity: RoomEquipment::class, mappedBy: 'equipment')]
    private Collection $room_equipments;

    #[ORM\Column]
    private ?bool $isSoftware = null;

    public function __construct()
    {
        $this->room_equipments = new ArrayCollection();
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
     * @return Collection<int, RoomEquipment>
     */
    public function getRoomEquipments(): Collection
    {
        return $this->room_equipments;
    }

    public function addRoomEquipment(RoomEquipment $roomEquipment): static
    {
        if (!$this->room_equipments->contains($roomEquipment)) {
            $this->room_equipments->add($roomEquipment);
            $roomEquipment->setEquipment($this);
        }

        return $this;
    }

    public function removeRoomEquipment(RoomEquipment $roomEquipment): static
    {
        if ($this->room_equipments->removeElement($roomEquipment)) {
            // set the owning side to null (unless already changed)
            if ($roomEquipment->getEquipment() === $this) {
                $roomEquipment->setEquipment(null);
            }
        }

        return $this;
    }

    public function isSoftware(): ?bool
    {
        return $this->isSoftware;
    }

    public function setSoftware(bool $isSoftware): static
    {
        $this->isSoftware = $isSoftware;

        return $this;
    }
}
