<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Messenger;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Webmunkeez\CQRSBundle\Query\QueryBusInterface;
use Webmunkeez\CQRSBundle\Query\QueryInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class QueryBus implements QueryBusInterface
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch(QueryInterface $query): mixed
    {
        /** @var HandledStamp|null $stamp */
        $stamp = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
        ;

        return null !== $stamp ? $stamp->getResult() : null;
    }
}
