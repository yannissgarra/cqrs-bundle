<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Doctrine\DBAL;

use Doctrine\DBAL\Query\QueryBuilder;
use Webmunkeez\CQRSBundle\Doctrine\EntityManagerAwareInterface;
use Webmunkeez\CQRSBundle\Doctrine\EntityManagerAwareTrait;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
abstract class AbstractDoctrineDBALRepository implements EntityManagerAwareInterface
{
    use EntityManagerAwareTrait;

    protected function createQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getConnection()->createQueryBuilder();
    }
}
