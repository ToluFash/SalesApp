<?php

namespace App\Entity;

use App\Repository\AccessTokenRepository;
use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessTokenRepository::class)]
class AccessToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'accessToken', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $authUser = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $expirationTime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthUser(): ?User
    {
        return $this->authUser;
    }

    public function setAuthUser(User $authUser): static
    {
        $this->authUser = $authUser;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getExpirationTime(): ?DateTimeInterface
    {
        return $this->expirationTime;
    }

    public function setExpirationTime(\DateTimeInterface $expirationTime): static
    {
        $this->expirationTime = $expirationTime;

        return $this;
    }
}
