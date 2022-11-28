<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Event;

use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as CoreEventDispatcherInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class EventDispatcher implements EventDispatcherInterface
{
    private CoreEventDispatcherInterface $eventDispatcher;

    public function __construct(CoreEventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function dispatch(EventInterface $event): EventInterface
    {
        /** @var EventInterface $event */
        $event = $this->eventDispatcher->dispatch($event);

        return $event;
    }
}
