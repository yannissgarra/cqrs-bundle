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

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch(CommandInterface $command): mixed
    {
        /** @var HandledStamp|null $stamp */
        $stamp = $this->bus->dispatch($command)
            ->last(HandledStamp::class)
        ;

        return null !== $stamp ? $stamp->getResult() : null;
    }
}
