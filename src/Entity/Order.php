<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $customer;

    #[ORM\OneToOne(inversedBy: 'orderid', targetEntity: OrderDetail::class, cascade: ['persist', 'remove'])]
    private $orderdetail;

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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getOrderdetail(): ?OrderDetail
    {
        return $this->orderdetail;
    }

    public function setOrderdetail(?OrderDetail $orderdetail): self
    {
        $this->orderdetail = $orderdetail;

        return $this;
    }

}
