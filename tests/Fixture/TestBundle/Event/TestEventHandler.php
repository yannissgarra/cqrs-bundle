<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event;

use Webmunkeez\CQRSBundle\Event\EventHandlerInterface;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestEventHandler implements EventHandlerInterface
{
    /**
     * @throws TestException
     */
    public function handle(TestEvent $event): string
    {
        if (TestEvent::NAME_FAILED === $event->getName()) {
            throw new TestException();
        }

        return $event->getName();
    }
}
