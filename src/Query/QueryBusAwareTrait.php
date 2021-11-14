<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Query;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
trait QueryBusAwareTrait
{
    private QueryBusInterface $queryBus;

    public function setQueryBus(QueryBusInterface $queryBus): void
    {
        $this->queryBus = $queryBus;
    }
}
