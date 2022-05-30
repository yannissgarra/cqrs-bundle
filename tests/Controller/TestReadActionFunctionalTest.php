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
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller\TestReadAction;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestNotFoundException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\Test;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestReadActionFunctionalTest extends AbstractActionFunctionalTest
{
    private TestReadAction $action;

    protected function setUp(): void
    {
        parent::setUp();

        $test = (new Test())
            ->setId(Uuid::fromString(self::DATA['id']))
            ->setTitle(self::DATA['title']);

        $this->entityManager->persist($test);
        $this->entityManager->flush();

        $this->action = static::getContainer()->get(TestReadAction::class);
    }

    public function testInvokeWithExistingIdShouldSucceed(): void
    {
        $response = $this->action->__invoke(Uuid::fromString(self::DATA['id']));

        $this->assertInstanceOf(Test::class, $response);
        $this->assertSame(self::DATA['id'], $response->getId()->toRfc4122());
        $this->assertSame(self::DATA['title'], $response->getTitle());
    }

    public function testInvokeWithNotExistingIdShouldFail(): void
    {
        $this->expectException(TestNotFoundException::class);

        $this->action->__invoke(Uuid::v4());
    }

    public function testInvokeWithoutIdShouldFail(): void
    {
        try {
            $this->action->__invoke();
        } catch (ValidationException $e) {
            $this->assertCount(1, $e->getViolations());
            $this->assertSame('id', $e->getViolations()[0]->getPropertyPath());

            return;
        }

        $this->fail();
    }
}
