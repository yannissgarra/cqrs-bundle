<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event;

use Webmunkeez\CQRSBundle\Event\AbstractEventListener;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Message\TestCreatedMessage;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestCreatedEventListener extends AbstractEventListener
{
    public function onTestCreatedEvent(TestCreatedEvent $event): void
    {
        $message = (new TestCreatedMessage())
            ->setId($event->getTest()->getId())
            ->setTitle($event->getTest()->getTitle());

        $this->validate($message);

        $this->dispatch($message);
    }

    public function onTestCreatedEvent2(TestCreatedEvent $event): void
    {
    }
}
