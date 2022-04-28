<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Webmunkeez\CQRSBundle\Model\EntityInterface;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Repository\TestWriteRepository;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
#[ORM\Entity(TestWriteRepository::class)]
#[ORM\Table('cqrs_test')]
class Test implements EntityInterface
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'guid', unique: true)]
    private Uuid $id;

    #[ORM\Column(name: 'title', type: 'string', nullable: true)]
    private ?string $title;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
