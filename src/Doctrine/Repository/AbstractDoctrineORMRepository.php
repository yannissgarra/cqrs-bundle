<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Webmunkeez\CQRSBundle\Model\EntityInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
abstract class AbstractDoctrineORMRepository extends ServiceEntityRepository
{
    public function persist(EntityInterface $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    public function remove(EntityInterface $entity): void
    {
        $this->getEntityManager()->remove($entity);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
