<?php

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event;

use Webmunkeez\CQRSBundle\Event\EventHandlerInterface;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestException;

final class TestEventHandler implements EventHandlerInterface
{
    public function __invoke(TestEvent $event): void
    {
        if (TestEvent::NAME_FAILED === $event->getName()) {
            throw new TestException();
        }
    }
}
