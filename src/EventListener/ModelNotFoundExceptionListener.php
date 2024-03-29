<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Webmunkeez\CQRSBundle\Exception\ModelNotFoundException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ModelNotFoundExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        if ($event->getThrowable() instanceof ModelNotFoundException) {
            $event->setThrowable(new NotFoundHttpException($event->getThrowable()->getMessage(), $event->getThrowable(), $event->getThrowable()->getCode()));
        }
    }
}
