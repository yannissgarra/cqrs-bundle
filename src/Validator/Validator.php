<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface as CoreValidatorInterface;
use Webmunkeez\CQRSBundle\Exception\ValidationException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class Validator implements ValidatorInterface
{
    private CoreValidatorInterface $validator;

    public function __construct(CoreValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(mixed $value): void
    {
        $violations = $this->validator->validate($value);

        if (count($violations) > 0) {
            $constraintViolations = [];

            foreach ($violations as $violation) {
                $constraintViolations[] = new ConstraintViolation($violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ValidationException($constraintViolations);
        }
    }
}
