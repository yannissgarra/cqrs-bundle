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
    public function testInvoke(): void
    {
        self::bootKernel();

        $action = static::getContainer()->get(EventAction::class);
        $response = $action->__invoke(TestEvent::NAME);

        $this->assertNull($response);
    }

    public function testInvokeException(): void
    {
        self::bootKernel();

        $action = static::getContainer()->get(EventAction::class);

        $this->expectException(TestException::class);

        $action->__invoke(TestEvent::NAME_FAILED);
    }
}
