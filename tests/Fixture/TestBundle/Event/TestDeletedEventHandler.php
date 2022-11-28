<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event;

use Webmunkeez\CQRSBundle\Event\AbstractEventHandler;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Message\TestDeletedMessage;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestDeletedEventHandler extends AbstractEventHandler
{
    public function handle(TestDeletedEvent $event): void
    {
        $message = (new TestDeletedMessage())
            ->setId($event->getTest()->getId());

        $this->validate($message);

        $this->dispatch($message);
    }
}
