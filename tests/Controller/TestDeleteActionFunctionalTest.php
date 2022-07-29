<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Controller;

use Symfony\Component\Uid\Uuid;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller\TestDeleteAction;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestDeletedEvent;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestNotFoundException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\Test;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestDeleteActionFunctionalTest extends AbstractActionFunctionalTest
{
    private TestDeleteAction $action;

    protected function setUp(): void
    {
        parent::setUp();

        $test = (new Test())
            ->setId(Uuid::fromString(self::DATA['id']))
            ->setTitle(self::DATA['title']);

        $this->entityManager->persist($test);
        $this->entityManager->flush();

        $this->action = static::getContainer()->get(TestDeleteAction::class);
    }

    public function testInvokeWithExistingIdShouldSucceed(): void
    {
        $this->action->__invoke(Uuid::fromString(self::DATA['id']));

        // test entity has been deleted
        $entity = $this->testRepository->findOneBy(['id' => Uuid::fromString(self::DATA['id'])]);
        $this->assertNull($entity);

        // test event has been sent
        $this->assertCount(1, $this->asyncTransport->get());
        /** @var TestDeletedEvent $event */
        $event = $this->asyncTransport->get()[0]->getMessage();
        $this->assertInstanceOf(TestDeletedEvent::class, $event);
        $this->assertTrue($event->getId()->equals(Uuid::fromString(self::DATA['id'])));
    }

    public function testInvokeWithNotExistingIdShouldFail(): void
    {
        try {
            $this->action->__invoke(Uuid::v4());
        } catch (TestNotFoundException $e) {
            // test entity has not been deleted
            $entity = $this->testRepository->findOneBy(['id' => Uuid::fromString(self::DATA['id'])]);
            $this->assertInstanceOf(Test::class, $entity);
            $this->assertTrue($entity->getId()->equals(Uuid::fromString(self::DATA['id'])));
            $this->assertSame(self::DATA['title'], $entity->getTitle());

            // test event has not been sent
            $this->assertCount(0, $this->asyncTransport->get());

            return;
        }

        $this->fail();
    }
}
