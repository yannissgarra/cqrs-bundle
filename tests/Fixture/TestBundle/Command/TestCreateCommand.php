<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Webmunkeez\CQRSBundle\Command\AbstractCommand;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestCreateCommand extends AbstractCommand
{
    #[Assert\NotBlank]
    private Uuid $id;

    #[Assert\NotBlank]
    private string $title;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
