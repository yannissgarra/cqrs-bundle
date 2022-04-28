<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller;

use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestEvent;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestEventDispatcher;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestEventHandler;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class EventAction
{
    private TestEventHandler $handler;
    private TestEventDispatcher $dispatcher;

    public function __construct(TestEventHandler $handler, TestEventDispatcher $dispatcher)
    {
        $this->handler = $handler;
        $this->dispatcher = $dispatcher;
    }

    public function handle(string $name): string
    {
        $event = (new TestEvent())->setName($name);

        return $this->handler->handle($event);
    }

    /**
     * @return array<EventInterface>
     */
    public function dispatch(string $name): array
    {
        $event = (new TestEvent())->setName($name);

        $this->dispatcher->dispatch($event);

        return $this->dispatcher->getEvents();
    }
}
