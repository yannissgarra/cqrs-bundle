<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Webmunkeez\CQRSBundle\Doctrine\ORM\AbstractDoctrineORMRepository;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Entity\Test;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
class TestWriteRepository extends AbstractDoctrineORMRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Test::class);
    }
}
