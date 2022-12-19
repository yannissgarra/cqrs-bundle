<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Doctrine\DBAL\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Webmunkeez\CQRSBundle\Doctrine\EntityManagerAwareInterface;
use Webmunkeez\CQRSBundle\Serializer\Normalizer\NormalizerAwareInterface;
use Webmunkeez\CQRSBundle\Serializer\Normalizer\NormalizerAwareTrait;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
abstract class AbstractDoctrineDBALRepository implements EntityManagerAwareInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private EntityManagerInterface $entityManager;

    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    protected function createQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getConnection()->createQueryBuilder();
    }
}
