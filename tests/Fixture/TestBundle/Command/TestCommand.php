<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command;

use Webmunkeez\CQRSBundle\Command\CommandInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestCommand implements CommandInterface
{
    public const NAME = 'TestCommand';
    public const NAME_FAILED = 'TestCommandFailed';

    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
