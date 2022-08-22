<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?string $accountNumber = null;

    #[ORM\Column(nullable: true)]
    private ?string $accountBalance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Money::class)]
    private Collection $money;

    public function __construct()
    {
        $this->money = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getAccountBalance(): ?string
    {
        return $this->accountBalance;
    }

    public function setAccountBalance(string $accountBalance): self
    {
        $this->accountBalance = $accountBalance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, Money>
     */
    public function getMoney(): Collection
    {
        return $this->money;
    }

    public function addMoney(Money $money): self
    {
        if (!$this->money->contains($money)) {
            $this->money->add($money);
            $money->setClient($this);
        }

        return $this;
    }

    public function removeMoney(Money $money): self
    {
        if ($this->money->removeElement($money)) {
            if ($money->getClient() === $this) {
                $money->setClient(null);
            }
        }

        return $this;
    }
}
