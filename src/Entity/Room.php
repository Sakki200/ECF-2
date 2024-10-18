<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column]
    private ?int $floor = null;

    #[ORM\Column]
    private ?int $door_number = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?bool $is_backup = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'room')]
    private Collection $reservations;

    /**
     * @var Collection<int, RoomEquipment>
     */
    #[ORM\OneToMany(targetEntity: RoomEquipment::class, mappedBy: 'room')]
    private Collection $roomEquipment;

    /**
     * @var Collection<int, RoomErgonomic>
     */
    #[ORM\OneToMany(targetEntity: RoomErgonomic::class, mappedBy: 'room')]
    private Collection $room_ergonomics;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->roomEquipment = new ArrayCollection();
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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): static
    {
        $this->floor = $floor;

        return $this;
    }

    public function getDoorNumber(): ?int
    {
        return $this->door_number;
    }

    public function setDoorNumber(int $door_number): static
    {
        $this->door_number = $door_number;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function isBackup(): ?bool
    {
        return $this->is_backup;
    }

    public function setBackup(bool $is_backup): static
    {
        $this->is_backup = $is_backup;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setRoom($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRoom() === $this) {
                $reservation->setRoom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RoomEquipment>
     */
    public function getRoomEquipment(): Collection
    {
        return $this->roomEquipment;
    }

    public function addRoomEquipment(RoomEquipment $roomEquipment): static
    {
        if (!$this->roomEquipment->contains($roomEquipment)) {
            $this->roomEquipment->add($roomEquipment);
            $roomEquipment->setRoom($this);
        }

        return $this;
    }

    public function removeRoomEquipment(RoomEquipment $roomEquipment): static
    {
        if ($this->roomEquipment->removeElement($roomEquipment)) {
            // set the owning side to null (unless already changed)
            if ($roomEquipment->getRoom() === $this) {
                $roomEquipment->setRoom(null);
            }
        }

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
            $roomErgonomic->setRoom($this);
        }

        return $this;
    }

    public function removeRoomErgonomic(RoomErgonomic $roomErgonomic): static
    {
        if ($this->room_ergonomics->removeElement($roomErgonomic)) {
            // set the owning side to null (unless already changed)
            if ($roomErgonomic->getRoom() === $this) {
                $roomErgonomic->setRoom(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
