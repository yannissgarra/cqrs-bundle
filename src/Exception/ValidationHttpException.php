<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Exception;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ValidationHttpException extends UnprocessableEntityHttpException
{
    public function __construct(ValidationException $previous)
    {
        parent::__construct($previous->getMessage(), $previous, $previous->getCode(), []);
    }
}
