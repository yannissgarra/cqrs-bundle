<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller\QueryAction;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query\TestQuery;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class QueryActionTest extends KernelTestCase
{
    public function testInvoke(): void
    {
        self::bootKernel();

        $action = static::getContainer()->get(QueryAction::class);
        $response = $action->__invoke(TestQuery::NAME);

        $this->assertSame(TestQuery::NAME, $response);
    }

    public function testInvokeException(): void
    {
        self::bootKernel();

        $action = static::getContainer()->get(QueryAction::class);

        $this->expectException(TestException::class);

        $action->__invoke(TestQuery::NAME_FAILED);
    }
}
