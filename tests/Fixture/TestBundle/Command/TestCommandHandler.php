<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command;

use Webmunkeez\CQRSBundle\Command\CommandHandlerInterface;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestCommandHandler implements CommandHandlerInterface
{
    /**
     * @throws TestException
     */
    public function handle(TestCommand $command): string
    {
        if (TestCommand::NAME_FAILED === $command->getName()) {
            throw new TestException();
        }

        return $command->getName();
    }
}
