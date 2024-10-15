<?php

namespace App\Entity;

use App\Repository\RoomErgonomicRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomErgonomicRepository::class)]
class RoomErgonomic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'room_ergonomics')]
    private ?Room $room = null;

    #[ORM\ManyToOne(inversedBy: 'room_ergonomics')]
    private ?Ergonomic $ergonomic = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): static
    {
        $this->room = $room;

        return $this;
    }

    public function getErgonomic(): ?Ergonomic
    {
        return $this->ergonomic;
    }

    public function setErgonomic(?Ergonomic $ergonomic): static
    {
        $this->ergonomic = $ergonomic;

        return $this;
    }
}
