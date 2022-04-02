<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller;

use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query\TestQuery;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query\TestQueryHandler;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class QueryAction
{
    private TestQueryHandler $handler;

    public function __construct(TestQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(string $name): string
    {
        $query = (new TestQuery())->setName($name);

        return $this->handler->handle($query);
    }
}
