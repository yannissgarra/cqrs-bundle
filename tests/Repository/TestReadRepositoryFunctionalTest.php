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
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestNotFoundException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Repository\TestReadRepository;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestReadRepositoryFunctionalTest extends KernelTestCase
{
    public const DATA = [
        'id' => 'd5f891ef-180a-4a35-94cb-5e5c2cc9e5ca',
        'title' => 'Test',
    ];

    private ?EntityManager $entityManager;
    private TestReadRepository $repository;

    protected function setUp(): void
    {
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();

        $metaData = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->updateSchema($metaData);

        $this->repository = static::getContainer()->get(TestReadRepository::class);

        $test = (new Test())
            ->setId(Uuid::fromString(self::DATA['id']))
            ->setTitle(self::DATA['title']);

        $this->entityManager->persist($test);
        $this->entityManager->flush();
    }

    public function testFindOneWithExistingIdShouldSucceed(): void
    {
        $test = $this->repository->findOne(Uuid::fromString(self::DATA['id']));

        $this->assertSame(self::DATA['title'], $test->getTitle());
    }

    public function testFindOneWithNotExistingIdShouldFail(): void
    {
        $this->expectException(TestNotFoundException::class);

        $this->repository->findOne(Uuid::v4());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
