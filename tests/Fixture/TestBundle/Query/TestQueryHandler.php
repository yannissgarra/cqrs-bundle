<?php

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query;

use Webmunkeez\CQRSBundle\Query\QueryHandlerInterface;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestException;

final class TestQueryHandler implements QueryHandlerInterface
{
    public function __invoke(TestQuery $query): string
    {
        if (TestQuery::NAME_FAILED === $query->getName()) {
            throw new TestException();
        }

        return $query->getName();
    }
}
