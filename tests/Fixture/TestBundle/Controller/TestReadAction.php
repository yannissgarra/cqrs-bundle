<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller;

use Symfony\Component\Uid\Uuid;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Entity\Test;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query\TestReadQuery;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query\TestReadQueryHandler;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestReadAction
{
    private TestReadQueryHandler $handler;

    public function __construct(TestReadQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(?Uuid $id = null): Test
    {
        $query = new TestReadQuery();

        if (null !== $id) {
            $query->setId($id);
        }

        return $this->handler->handle($query);
    }
}
