<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event;

use Webmunkeez\CQRSBundle\Event\EventDispatcherInterface;
use Webmunkeez\CQRSBundle\Event\EventInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestEventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array<EventInterface>
     */
    private array $events = [];

    public function dispatch(TestEvent $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return array<EventInterface>
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
