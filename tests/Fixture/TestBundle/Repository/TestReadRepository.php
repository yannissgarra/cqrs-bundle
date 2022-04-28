<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Repository;

use Symfony\Component\Uid\Uuid;
use Webmunkeez\CQRSBundle\Doctrine\Repository\AbstractDoctrineDBALRepository;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\Test;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
class TestReadRepository extends AbstractDoctrineDBALRepository
{
    public function findOne(Uuid $id): Test
    {
        $qb = $this->createQueryBuilder();

        $qb->select('id', 'title')
            ->from('cqrs_test', 'test');

        $qb->andWhere($qb->expr()->eq('id', ':id'))
            ->setParameter('id', $id);

        $datas = $qb->executeQuery()->fetchAssociative();

        if (false === $datas) {
            throw new \RuntimeException('Test not found.');
        }

        return (new Test())
            ->setId(Uuid::fromString($datas['id']))
            ->setTitle($datas['title']);
    }
}
