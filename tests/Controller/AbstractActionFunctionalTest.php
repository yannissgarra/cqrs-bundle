<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Repository\TestWriteRepository;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
abstract class AbstractActionFunctionalTest extends KernelTestCase
{
    public const DATA = [
        'id' => 'd5f891ef-180a-4a35-94cb-5e5c2cc9e5ca',
        'title' => 'Test',
    ];

    protected EntityManagerInterface $entityManager;
    protected TransportInterface $asyncTransport;
    protected TestWriteRepository $testRepository;

    protected function setUp(): void
    {
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();

        $metaData = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->updateSchema($metaData);

        $this->asyncTransport = static::getContainer()->get('messenger.transport.async');

        $this->testRepository = static::getContainer()->get(TestWriteRepository::class);
    }
}
