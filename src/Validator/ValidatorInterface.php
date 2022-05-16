<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Validator;

use Webmunkeez\CQRSBundle\Exception\ValidationException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
interface ValidatorInterface
{
    /**
     * @throws ValidationException
     */
    public function validate(mixed $value): void;
}
