<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Query;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Uid\Uuid;
use Webmunkeez\CQRSBundle\Query\QueryValueResolver;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query\TestResolverQuery;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class QueryValueResolverFunctionalTest extends KernelTestCase
{
    private QueryValueResolver $resolver;

    protected function setUp(): void
    {
        $this->resolver = static::getContainer()->get(QueryValueResolver::class);
    }

    public function testResolveShoudSucceed(): void
    {
        $id = Uuid::v4();

        $request = new Request([
            'page' => 1,
        ], [], [
            '_route_params' => [
                'id' => $id,
            ],
        ], [], [], [], json_encode([
            'title' => 'This is a query',
        ]), );

        $argument = new ArgumentMetadata('query', TestResolverQuery::class, false, false, null);

        $arguments = $this->resolver->resolve($request, $argument);

        $this->assertCount(1, $arguments);
        $this->assertInstanceOf(TestResolverQuery::class, $arguments[0]);
        $this->assertInstanceOf(Uuid::class, $arguments[0]->getId());
        $this->assertTrue($arguments[0]->getId()->equals($id));
        $this->assertSame('This is a query', $arguments[0]->getTitle());
        $this->assertSame(1, $arguments[0]->getPage());
    }
}
