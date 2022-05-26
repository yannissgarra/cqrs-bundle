<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller\EventAction;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestEvent;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class EventActionTest extends KernelTestCase
{
    public function testHandle(): void
    {
        self::bootKernel();

        $action = static::getContainer()->get(EventAction::class);
        $response = $action->handle(TestEvent::NAME);

        $this->assertSame(TestEvent::NAME, $response);
    }

    public function testHandleException(): void
    {
        self::bootKernel();

        $action = static::getContainer()->get(EventAction::class);

        $this->expectException(TestException::class);

        $action->handle(TestEvent::NAME_FAILED);
    }

    public function testDispatch(): void
    {
        self::bootKernel();

        $action = static::getContainer()->get(EventAction::class);

        $response = $action->dispatch(TestEvent::NAME);
        $this->assertCount(1, $response);

        $response = $action->dispatch(TestEvent::NAME);
        $this->assertCount(2, $response);
    }
}
