<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller;

use Webmunkeez\CQRSBundle\Query\QueryBusAwareInterface;
use Webmunkeez\CQRSBundle\Query\QueryBusAwareTrait;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query\TestQuery;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class QueryAction implements QueryBusAwareInterface
{
    use QueryBusAwareTrait;

    public function __invoke(string $name): string
    {
        $query = (new TestQuery())->setName($name);

        return $this->queryBus->dispatch($query);
    }
}
