<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Query;

use Webmunkeez\CQRSBundle\Validator\ValidatorAwareInterface;
use Webmunkeez\CQRSBundle\Validator\ValidatorAwareTrait;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
abstract class AbstractQueryHandler implements QueryHandlerInterface, ValidatorAwareInterface
{
    use ValidatorAwareTrait;

    protected function validate(mixed $value): void
    {
        $this->validator->validate($value);
    }
}
