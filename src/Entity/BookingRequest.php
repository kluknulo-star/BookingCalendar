<?php

namespace App\Entity;

use App\Repository\BookingRequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRequestRepository::class)
 */
class BookingRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fio;

    /**
     * @ORM\Column(type="string", length=14, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="boolean", nullable=true, nullable=true)
     */
    private $approved;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_room;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_create;

    /**
     * @ORM\Column(type="datetime", nullable=true, nullable=true)
     */
    private $date_update;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_user_create;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_user_update;



    public function __construct()
    {
        $this -> date_create = new \DateTimeImmutable();
        $this -> id_user_create = 1;
        $this -> active = true;
        $this -> approved = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getFio(): ?string
    {
        return $this->fio;
    }

    public function setFio(string $fio): self
    {
        $this->fio = $fio;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(?bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function getIdRoom(): ?int
    {
        return $this->id_room;
    }

    public function setIdRoom(int $id_room): self
    {
        $this->id_room = $id_room;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeInterface $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->date_update;
    }

    public function setDateUpdate(?\DateTimeInterface $date_update): self
    {
        $this->date_update = $date_update;

        return $this;
    }

    public function getIdUserCreate(): ?int
    {
        return $this->id_user_create;
    }

    public function setIdUserCreate(int $id_user_create): self
    {
        $this->id_user_create = $id_user_create;

        return $this;
    }

    public function getIdUserUpdate(): ?int
    {
        return $this->id_user_update;
    }

    public function setIdUserUpdate(int $id_user_update): self
    {
        $this->id_user_update = $id_user_update;

        return $this;
    }
}