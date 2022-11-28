<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\EventListener;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmunkeez\CQRSBundle\EventListener\EntityNotFoundExceptionListener;
use Webmunkeez\CQRSBundle\Exception\EntityNotFoundException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class EntityNotFoundExceptionListenerTest extends TestCase
{
    /** @var KernelInterface&MockObject */
    private KernelInterface $kernel;

    private EntityNotFoundExceptionListener $listener;

    protected function setUp(): void
    {
        /** @var KernelInterface&MockObject $kernel */
        $kernel = $this->getMockForAbstractClass(Kernel::class, ['test', true]);
        $this->kernel = $kernel;

        $this->listener = new EntityNotFoundExceptionListener();
    }

    public function testWithEntityNotFoundExceptionShouldSucceed(): void
    {
        $exception = new EntityNotFoundException();

        $request = new Request();

        $event = new ExceptionEvent($this->kernel, $request, HttpKernelInterface::MAIN_REQUEST, $exception);

        $this->listener->onKernelException($event);

        $this->assertInstanceOf(NotFoundHttpException::class, $event->getThrowable());
        $this->assertSame($exception->getMessage(), $event->getThrowable()->getMessage());
        $this->assertSame($exception->getCode(), $event->getThrowable()->getCode());
        $this->assertInstanceOf(EntityNotFoundException::class, $event->getThrowable()->getPrevious());
        $this->assertSame($exception, $event->getThrowable()->getPrevious());
    }

    public function testWithOtherExceptionShouldFail(): void
    {
        $exception = new \Exception();

        $request = new Request();

        $event = new ExceptionEvent($this->kernel, $request, HttpKernelInterface::MAIN_REQUEST, $exception);

        $this->listener->onKernelException($event);

        $this->assertInstanceOf(\Exception::class, $event->getThrowable());
    }
}
