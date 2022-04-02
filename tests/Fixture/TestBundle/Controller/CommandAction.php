<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller;

use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestCommand;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestCommandHandler;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class CommandAction
{
    private TestCommandHandler $handler;

    public function __construct(TestCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(string $name): string
    {
        $command = (new TestCommand())->setName($name);

        return $this->handler->handle($command);
    }
}
