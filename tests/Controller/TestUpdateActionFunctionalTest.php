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
use Webmunkeez\CQRSBundle\Exception\ValidationException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller\TestUpdateAction;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestUpdatedEvent;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestNotFoundException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\Test;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestUpdateActionFunctionalTest extends AbstractActionFunctionalTest
{
    private TestUpdateAction $action;

    protected function setUp(): void
    {
        parent::setUp();

        $test = (new Test())
            ->setId(Uuid::fromString(self::DATA['id']))
            ->setTitle(self::DATA['title']);

        $this->entityManager->persist($test);
        $this->entityManager->flush();

        $this->action = static::getContainer()->get(TestUpdateAction::class);
    }

    public function testInvokeWithExistingIdAndTitleShouldSucceed(): void
    {
        $this->action->__invoke(Uuid::fromString(self::DATA['id']), 'Test2');

        // test entity has been updated
        $entity = $this->testRepository->findOneBy(['id' => Uuid::fromString(self::DATA['id'])]);
        $this->assertInstanceOf(Test::class, $entity);
        $this->assertTrue($entity->getId()->equals(Uuid::fromString(self::DATA['id'])));
        $this->assertSame('Test2', $entity->getTitle());

        // test event has been sent
        $this->assertCount(1, $this->asyncTransport->get());
        /** @var TestUpdatedEvent $event */
        $event = $this->asyncTransport->get()[0]->getMessage();
        $this->assertInstanceOf(TestUpdatedEvent::class, $event);
        $this->assertTrue($event->getId()->equals(Uuid::fromString(self::DATA['id'])));
        $this->assertSame('Test2', $event->getTitle());
    }

    public function testInvokeWithNotExistingIdAndTitleShouldThrowException(): void
    {
        try {
            $this->action->__invoke(Uuid::v4(), 'Test2');
        } catch (TestNotFoundException $e) {
            // test entity has not been updated
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

    public function testInvokeWithExistingIdAndWithoutTitleShouldThrowException(): void
    {
        try {
            $this->action->__invoke(Uuid::fromString(self::DATA['id']));
        } catch (ValidationException $e) {
            $this->assertCount(1, $e->getViolations());
            $this->assertSame('title', $e->getViolations()[0]->getPropertyPath());

            // test entity has not been updated
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
