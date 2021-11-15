<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Messenger;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Webmunkeez\CQRSBundle\Messenger\ExceptionMiddleware;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestCommand;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ExceptionMiddlewareTest extends TestCase
{
    private Envelope $envelope;

    /**
     * @var MiddlewareInterface&MockObject
     */
    private MiddlewareInterface $middleware;

    /**
     * @var StackInterface&MockObject
     */
    private StackInterface $stack;

    protected function setUp(): void
    {
        $command = (new TestCommand())->setName('TestCommand');

        $this->envelope = new Envelope($command);

        $this->middleware = $this->getMockBuilder(MiddlewareInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->stack = $this->getMockBuilder(StackInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->stack->method('next')->willReturn($this->middleware);
    }

    public function testHandle(): void
    {
        $this->middleware->method('handle')->willReturn($this->envelope);

        $middleware = new ExceptionMiddleware();
        $result = $middleware->handle($this->envelope, $this->stack);

        $this->assertInstanceOf(TestCommand::class, $this->envelope->getMessage());
        $this->assertEquals($this->envelope->getMessage()->getName(), $result->getMessage()->getName());
    }

    public function testHandleException(): void
    {
        $this->middleware->method('handle')->willThrowException(new HandlerFailedException($this->envelope, [new TestException()]));

        $this->expectException(TestException::class);

        $middleware = new ExceptionMiddleware();
        $middleware->handle($this->envelope, $this->stack);
    }
}
