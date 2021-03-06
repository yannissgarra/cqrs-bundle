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
use Webmunkeez\CQRSBundle\Event\EventDispatcherInterface;
use Webmunkeez\CQRSBundle\Event\EventInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class MessengerEventDispatcher implements EventDispatcherInterface
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch(EventInterface $event): void
    {
        $this->bus->dispatch($event);
    }
}
