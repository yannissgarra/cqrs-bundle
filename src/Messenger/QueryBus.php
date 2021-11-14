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

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->bus = $queryBus;
    }

    public function dispatch(QueryInterface $query): mixed
    {
        /** @var HandledStamp|null $stamp The value that was returned by the last message handler. */
        $stamp = $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class);

        if (null === $stamp) {
            return null;
        }

        return $stamp->getResult();
    }
}
