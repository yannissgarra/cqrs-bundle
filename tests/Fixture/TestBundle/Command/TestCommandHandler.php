<?php

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command;

use Webmunkeez\CQRSBundle\Command\CommandHandlerInterface;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestException;

final class TestCommandHandler implements CommandHandlerInterface
{
    public function __invoke(TestCommand $command): string
    {
        if (TestCommand::NAME_FAILED === $command->getName()) {
            throw new TestException();
        }

        return $command->getName();
    }
}
