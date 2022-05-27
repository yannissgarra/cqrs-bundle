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
use Webmunkeez\CQRSBundle\Exception\ValidationException;
use Webmunkeez\CQRSBundle\Exception\ValidationHttpException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ValidationExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        if ($event->getThrowable() instanceof ValidationException) {
            $event->setThrowable(new ValidationHttpException($event->getThrowable()->getMessage(), $event->getThrowable(), $event->getThrowable()->getCode()));
        }
    }
}
