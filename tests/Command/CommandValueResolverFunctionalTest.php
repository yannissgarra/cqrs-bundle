<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Uid\Uuid;
use Webmunkeez\CQRSBundle\Command\CommandValueResolver;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestResolverCommand;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class CommandValueResolverFunctionalTest extends KernelTestCase
{
    private CommandValueResolver $resolver;

    protected function setUp(): void
    {
        $this->resolver = static::getContainer()->get(CommandValueResolver::class);
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
            'title' => 'This is a command',
        ]), );

        $argument = new ArgumentMetadata('command', TestResolverCommand::class, false, false, null);

        $arguments = $this->resolver->resolve($request, $argument);

        $this->assertCount(1, $arguments);
        $this->assertInstanceOf(TestResolverCommand::class, $arguments[0]);
        $this->assertInstanceOf(Uuid::class, $arguments[0]->getId());
        $this->assertTrue($arguments[0]->getId()->equals($id));
        $this->assertSame('This is a command', $arguments[0]->getTitle());
        $this->assertSame(1, $arguments[0]->getPage());
    }
}
