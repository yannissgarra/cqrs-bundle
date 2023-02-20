<?php

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
#[UniqueEntity(['id'])]
abstract class AbstractEntity implements EntityInterface
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'uuid', unique: true)]
    #[Assert\NotBlank]
    #[Assert\Uuid]
    private Uuid $id;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    #[Assert\NotBlank]
    private \DateTime $createdAt;

    #[ORM\Column(name: 'last_updated_at', type: 'datetime')]
    #[Assert\NotBlank]
    private \DateTime $lastUpdatedAt;

    public function __construct()
    {
        // init values
        $this->generateId()
            ->setCreatedAt(new \DateTime())
            ->updateLastUpdatedAt()
        ;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function generateId(): static
    {
        $this->setId(Uuid::v4());

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $date): static
    {
        $this->createdAt = $date;

        return $this;
    }

    public function getLastUpdatedAt(): \DateTime
    {
        return $this->lastUpdatedAt;
    }

    public function setLastUpdatedAt(\DateTime $date): static
    {
        $this->lastUpdatedAt = $date;

        return $this;
    }

    public function updateLastUpdatedAt(): static
    {
        $this->setLastUpdatedAt(new \DateTime());

        return $this;
    }
}
