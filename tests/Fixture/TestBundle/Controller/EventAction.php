<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller;

use Webmunkeez\CQRSBundle\Event\EventBusAwareInterface;
use Webmunkeez\CQRSBundle\Event\EventBusAwareTrait;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestEvent;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class EventAction implements EventBusAwareInterface
{
    use EventBusAwareTrait;

    public function __invoke(string $name): void
    {
        $event = (new TestEvent())->setName($name);

        $this->eventBus->dispatch($event);
    }
}
