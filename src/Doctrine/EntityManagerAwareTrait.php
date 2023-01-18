<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Webmunkeez\CQRSBundle\Model\EntityInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
trait EntityManagerAwareTrait
{
    protected EntityManagerInterface $entityManager;

    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    protected function persist(EntityInterface $entity): void
    {
        $this->entityManager->persist($entity);
    }

    protected function remove(EntityInterface $entity): void
    {
        $this->entityManager->remove($entity);
    }

    protected function flush(): void
    {
        $this->entityManager->flush();
    }

    protected function clear(): void
    {
        $this->entityManager->clear();
    }
}
