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
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller\TestCreateAction;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\Test;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestCreateActionFunctionalTest extends AbstractActionFunctionalTest
{
    private TestCreateAction $action;

    protected function setUp(): void
    {
        parent::setUp();

        $this->action = static::getContainer()->get(TestCreateAction::class);
    }

    public function testInvokeWithTitleShouldSucceed(): void
    {
        $this->action->__invoke(Uuid::fromString(self::DATA['id']), self::DATA['title']);

        // test entity has been created
        $entity = $this->testRepository->findOneBy(['id' => Uuid::fromString(self::DATA['id'])]);
        $this->assertInstanceOf(Test::class, $entity);
        $this->assertTrue($entity->getId()->equals(Uuid::fromString(self::DATA['id'])));
        $this->assertSame(self::DATA['title'], $entity->getTitle());
    }

    public function testInvokeWithoutTitleShouldFail(): void
    {
        try {
            $this->action->__invoke(Uuid::fromString(self::DATA['id']));
        } catch (ValidationException $e) {
            $this->assertCount(1, $e->getViolations());
            $this->assertSame('title', $e->getViolations()[0]->getPropertyPath());

            // test entity has not been created
            $entity = $this->testRepository->findOneBy(['id' => Uuid::fromString(self::DATA['id'])]);
            $this->assertNull($entity);

            return;
        }

        $this->fail();
    }
}
