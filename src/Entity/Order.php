<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $orderdate;

    #[ORM\Column(type: 'string', length: 255)]
    private $shipcity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderdate(): ?\DateTimeInterface
    {
        return $this->orderdate;
    }

    public function setOrderdate(\DateTimeInterface $orderdate): self
    {
        $this->orderdate = $orderdate;

        return $this;
    }

    public function getShipcity(): ?string
    {
        return $this->shipcity;
    }

    public function setShipcity(string $shipcity): self
    {
        $this->shipcity = $shipcity;

        return $this;
    }

}
