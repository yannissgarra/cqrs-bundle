<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Messenger;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Webmunkeez\CQRSBundle\Command\CommandBusInterface;
use Webmunkeez\CQRSBundle\Command\CommandInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class CommandBus implements CommandBusInterface
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->bus = $commandBus;
    }

    public function dispatch(CommandInterface $command): mixed
    {
        /** @var HandledStamp|null $stamp The value that was returned by the last message handler. */
        $stamp = $this->bus
            ->dispatch($command)
            ->last(HandledStamp::class);

        if (null === $stamp) {
            return null;
        }

        return $stamp->getResult();
    }
}
