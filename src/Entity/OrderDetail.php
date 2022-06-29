<?php

namespace App\Entity;

use App\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderDetailRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: OrderDetailRepository::class)]
class OrderDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'orderDetails')]
    private $product;

    #[ORM\OneToOne(mappedBy: 'orderdetail', targetEntity: Order::class, cascade: ['persist', 'remove'])]
    private $orderid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }
    
    public function upQuantity(): self
    {
        $this->quantity += 1;

        return $this;
    }
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function getProduct2(?Product $product): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getOrderid(): ?Order
    {
        return $this->orderid;
    }

    public function setOrderid(?Order $orderid): self
    {
        // unset the owning side of the relation if necessary
        if ($orderid === null && $this->orderid !== null) {
            $this->orderid->setOrderdetail(null);
        }

        // set the owning side of the relation if necessary
        if ($orderid !== null && $orderid->getOrderdetail() !== $this) {
            $orderid->setOrderdetail($this);
        }

        $this->orderid = $orderid;

        return $this;
    }

}
