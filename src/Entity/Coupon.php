<?php

namespace App\Entity;

use App\Enum\CouponTypeEnum;
use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    private string $code;

    #[ORM\Column(type: 'string', enumType: CouponTypeEnum::class)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: [CouponTypeEnum::FIXED, CouponTypeEnum::PERCENT])]
    private CouponTypeEnum $type;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    private int $value;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isActive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getType(): string
    {
        return $this->type->value;
    }

    public function setType(CouponTypeEnum $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }
}
