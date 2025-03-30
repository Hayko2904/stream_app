<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 16)]
    #[Assert\Regex(
        pattern: '/^[0-9]{16}$/',
        message: 'Invalid credit card number',
        groups: ['payment']
    )]
    private ?string $creditCardNumber = null;

    #[ORM\Column(length: 5)]
    #[Assert\Regex(
        pattern: '/^(0[1-9]|1[0-2])\/([0-9]{2})$/',
        message: 'Invalid expiration date format (MM/YY)',
        groups: ['payment']
    )]
    private ?string $cardExpiration = null;

    #[ORM\Column(length: 3)]
    #[Assert\Regex(
        pattern: '/^[0-9]{3}$/',
        message: 'Invalid CVV',
        groups: ['payment']
    )]
    private ?string $cvv = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Card holder name is required', groups: ['payment'])]
    private ?string $cardHolderName = null;

    #[ORM\OneToOne(inversedBy: 'payment')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreditCardNumber(): ?string
    {
        return $this->creditCardNumber;
    }

    public function setCreditCardNumber(string $creditCardNumber): static
    {
        $this->creditCardNumber = preg_replace('/\s+/', '', $creditCardNumber);
        return $this;
    }

    public function getCardExpiration(): ?string
    {
        return $this->cardExpiration;
    }

    public function setCardExpiration(string $cardExpiration): static
    {
        $this->cardExpiration = $cardExpiration;
        return $this;
    }

    public function getCvv(): ?string
    {
        return $this->cvv;
    }

    public function setCvv(string $cvv): static
    {
        $this->cvv = $cvv;
        return $this;
    }

    public function getCardHolderName(): ?string
    {
        return $this->cardHolderName;
    }

    public function setCardHolderName(string $cardHolderName): static
    {
        $this->cardHolderName = $cardHolderName;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }
} 