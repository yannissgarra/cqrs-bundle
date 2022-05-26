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
use Symfony\Component\Messenger\Transport\TransportInterface;
use Webmunkeez\CQRSBundle\Event\EventDispatcherInterface;
use Webmunkeez\CQRSBundle\Messenger\MessengerEventDispatcher;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestEvent;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class MessengerEventDispatcherFunctionalTest extends KernelTestCase
{
    private TransportInterface $asyncTransport;
    private EventDispatcherInterface $dispatcher;

    protected function setUp(): void
    {
        $this->asyncTransport = static::getContainer()->get('messenger.transport.async');

        $this->dispatcher = static::getContainer()->get(MessengerEventDispatcher::class);
    }

    public function testDispatchShouldSucceed(): void
    {
        $event = new TestEvent();

        $this->dispatcher->dispatch($event);

        $this->assertCount(1, $this->asyncTransport->get());
        $this->assertInstanceOf(TestEvent::class, $this->asyncTransport->get()[0]->getMessage());
    }
}
