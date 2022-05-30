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
trait ValidatorAwareTrait
{
    protected ValidatorInterface $validator;

    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * @throws ValidationException
     */
    protected function validate(mixed $value): void
    {
        $this->validator->validate($value);
    }
}
