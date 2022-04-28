<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Doctrine\Repository;

use Doctrine\DBAL\Query\QueryBuilder;

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
