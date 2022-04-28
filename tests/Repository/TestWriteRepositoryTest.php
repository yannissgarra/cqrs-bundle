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
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Repository\TestWriteRepository;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestWriteRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;
    private TestWriteRepository $repository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();

        $this->repository = static::getContainer()
            ->get(TestWriteRepository::class);

        $metaData = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->updateSchema($metaData);
    }

    public function testSave(): void
    {
        $test = (new Test())
            ->setId(Uuid::fromString('592860e5-b215-49f5-96d2-a184169af910'))
            ->setTitle('Test');

        $this->repository->persist($test);
        $this->repository->flush();

        $this->assertCount(1, $this->repository->findAll());
        $this->assertEquals('Test', $this->repository->findOneBy(['id' => Uuid::fromString('592860e5-b215-49f5-96d2-a184169af910')])->getTitle());
    }

    public function testUpdate(): void
    {
        $test = (new Test())
            ->setId(Uuid::fromString('592860e5-b215-49f5-96d2-a184169af910'))
            ->setTitle('Test');

        $this->repository->persist($test);
        $this->repository->flush();

        $this->assertCount(1, $this->repository->findAll());

        $test->setTitle('Test2');

        $this->repository->flush();

        $this->assertEquals('Test2', $this->repository->findOneBy(['id' => Uuid::fromString('592860e5-b215-49f5-96d2-a184169af910')])->getTitle());
    }

    public function testRemove(): void
    {
        $test = (new Test())
            ->setId(Uuid::fromString('592860e5-b215-49f5-96d2-a184169af910'))
            ->setTitle('Test');

        $this->repository->persist($test);
        $this->repository->flush();

        $this->assertCount(1, $this->repository->findAll());

        $this->repository->remove($test);
        $this->repository->flush();

        $this->assertCount(0, $this->repository->findAll());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
