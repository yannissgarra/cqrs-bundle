<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Command;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Webmunkeez\CQRSBundle\Command\CommandValueResolver;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestResolverCommand;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query\TestResolverQuery;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class CommandValueResolverTest extends TestCase
{
    private CommandValueResolver $resolver;

    /**
     * @var SerializerInterface&MockObject
     **/
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        /** @var SerializerInterface&MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->disableOriginalConstructor()->getMock();
        $this->serializer = $serializer;

        $this->resolver = new CommandValueResolver($this->serializer);
    }

    public function testResolveShouldSucceed(): void
    {
        $testCommand = (new TestResolverCommand())->setId(Uuid::v4())->setTitle('Test');

        $this->serializer->method('deserialize')->willReturn($testCommand);

        $request = new Request();
        $argument = new ArgumentMetadata('command', TestResolverCommand::class, false, false, null);

        $arguments = $this->resolver->resolve($request, $argument);

        $this->assertCount(1, $arguments);
        $this->assertInstanceOf(TestResolverCommand::class, $arguments[0]);
        $this->assertSame('Test', $arguments[0]->getTitle());
    }

    public function testResolveWithoutTypeShouldFail(): void
    {
        $request = new Request();
        $argument = new ArgumentMetadata('command', null, false, false, null);

        $arguments = $this->resolver->resolve($request, $argument);

        $this->assertCount(0, $arguments);
    }

    public function testResolveWithWrongTypeShouldFail(): void
    {
        $request = new Request();
        $argument = new ArgumentMetadata('command', TestResolverQuery::class, false, false, null);

        $arguments = $this->resolver->resolve($request, $argument);

        $this->assertCount(0, $arguments);
    }
}
