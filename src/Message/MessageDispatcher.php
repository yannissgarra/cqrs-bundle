<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Message;

use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class MessageDispatcher implements MessageDispatcherInterface
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch(MessageInterface $message): void
    {
        $this->bus->dispatch($message);
    }
}
