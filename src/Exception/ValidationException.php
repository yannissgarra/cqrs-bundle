<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Exception;

use Webmunkeez\CQRSBundle\Validator\ConstraintViolation;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ValidationException extends RuntimeException
{
    /**
     * @var array<ConstraintViolation>
     */
    private array $violations;

    /**
     * @param array<ConstraintViolation> $violations
     */
    public function __construct(array $violations, string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        // init values
        $this->violations = $violations;
    }

    /**
     * @return array<ConstraintViolation>
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
