<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller;

use Webmunkeez\CQRSBundle\Command\CommandBusAwareInterface;
use Webmunkeez\CQRSBundle\Command\CommandBusAwareTrait;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestCommand;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class CommandAction implements CommandBusAwareInterface
{
    use CommandBusAwareTrait;

    public function __invoke(string $name): string
    {
        $command = (new TestCommand())->setName($name);

        return $this->commandBus->dispatch($command);
    }
}
