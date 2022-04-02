<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query;

use Webmunkeez\CQRSBundle\Query\QueryHandlerInterface;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestQueryHandler implements QueryHandlerInterface
{
    /**
     * @throws TestException
     */
    public function handle(TestQuery $query): string
    {
        if (TestQuery::NAME_FAILED === $query->getName()) {
            throw new TestException();
        }

        return $query->getName();
    }
}
