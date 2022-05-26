<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Messenger;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Webmunkeez\CQRSBundle\Event\EventDispatcherInterface;
use Webmunkeez\CQRSBundle\Messenger\MessengerEventDispatcher;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestEvent;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class MessengerEventDispatcherFunctionalTest extends KernelTestCase
{
    private EventDispatcherInterface $dispatcher;

    protected function setUp(): void
    {
        $this->dispatcher = static::getContainer()->get(MessengerEventDispatcher::class);
    }

    public function testDispatchShouldSucceed(): void
    {
        $event = (new TestEvent())->setName(TestEvent::NAME);

        $this->expectNotToPerformAssertions();

        $this->dispatcher->dispatch($event);
    }

    public function testDispatchShouldFail(): void
    {
        $event = (new TestEvent())->setName(TestEvent::NAME_FAILED);

        $this->expectException(HandlerFailedException::class);

        $this->dispatcher->dispatch($event);
    }
}
