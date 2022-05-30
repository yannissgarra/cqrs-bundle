<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query;

use Webmunkeez\CQRSBundle\Exception\ValidationException;
use Webmunkeez\CQRSBundle\Query\AbstractQueryHandler;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestNotFoundException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\Test;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Repository\TestReadRepository;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestReadQueryHandler extends AbstractQueryHandler
{
    private TestReadRepository $repository;

    public function __construct(TestReadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws TestNotFoundException
     * @throws ValidationException
     */
    public function handle(TestReadQuery $query): Test
    {
        $this->validate($query);

        $entity = $this->repository->findOne($query->getId());

        if (null === $entity) {
            throw new TestNotFoundException();
        }

        return $entity;
    }
}
