<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\Test;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Repository\TestReadRepository;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestReadRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;
    private TestReadRepository $repository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();

        $this->repository = static::getContainer()
            ->get(TestReadRepository::class);

        $metaData = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->updateSchema($metaData);

        $test = (new Test())
            ->setId(Uuid::fromString('592860e5-b215-49f5-96d2-a184169af910'))
            ->setTitle('Test');

        $this->entityManager->persist($test);
        $this->entityManager->flush();
    }

    public function testRead(): void
    {
        $test = $this->repository->findOne(Uuid::fromString('592860e5-b215-49f5-96d2-a184169af910'));

        $this->assertEquals('Test', $test->getTitle());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}