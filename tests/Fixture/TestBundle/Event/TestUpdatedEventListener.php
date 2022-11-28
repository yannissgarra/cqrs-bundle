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
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Message\TestUpdatedMessage;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestUpdatedEventListener extends AbstractEventListener
{
    public function onTestUpdatedEvent(TestUpdatedEvent $event): void
    {
        $message = (new TestUpdatedMessage())
            ->setId($event->getTest()->getId())
            ->setTitle($event->getTest()->getTitle());

        $this->validate($message);

        $this->dispatch($message);
    }
}
