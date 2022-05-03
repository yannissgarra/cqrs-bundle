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
use Webmunkeez\CQRSBundle\Messenger\MessengerEventDispatcher;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestEvent;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class MessengerEventDispatcherTest extends KernelTestCase
{
    public function testDispatch(): void
    {
        self::bootKernel();

        $event = (new TestEvent())->setName(TestEvent::NAME);

        $dispatcher = static::getContainer()->get(MessengerEventDispatcher::class);
        $response = $dispatcher->dispatch($event);

        $this->assertNull($response);
    }

    public function testDispatchException(): void
    {
        self::bootKernel();

        $event = (new TestEvent())->setName(TestEvent::NAME_FAILED);

        $dispatcher = static::getContainer()->get(MessengerEventDispatcher::class);

        $this->expectException(HandlerFailedException::class);

        $dispatcher->dispatch($event);
    }
}
