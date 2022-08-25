<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MoneyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoneyRepository::class)]
class Money
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(nullable: true, type: "decimal", precision: 10, scale: 2)]
    private $moneyDeposit = null;

    #[ORM\Column(nullable: true, type: "decimal", precision: 10, scale: 2)]
    private $moneyWithdrawal = null;

    #[ORM\ManyToOne(inversedBy: 'money')]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoneyWithdrawal(): ?string
    {
        return $this->moneyWithdrawal;
    }

    public function setMoneyWithdrawal(?string $moneyWithdrawal): self
    {
        $this->moneyWithdrawal = $moneyWithdrawal;

        return $this;
    }

    public function getMoneyDeposit(): ?string
    {
        return $this->moneyDeposit;
    }

    public function setMoneyDeposit(?string $moneyDeposit): self
    {
        $this->moneyDeposit = $moneyDeposit;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
