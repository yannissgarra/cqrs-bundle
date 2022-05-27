<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Serializer\Normalizer;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Webmunkeez\CQRSBundle\Exception\ValidationException;
use Webmunkeez\CQRSBundle\Exception\ValidationHttpException;
use Webmunkeez\CQRSBundle\Validator\ConstraintViolation;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ValidationExceptionNormalizerFunctionalTest extends KernelTestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = static::getContainer()->get('serializer');
    }

    public function testNormalizeWithValidationHttpExceptionShouldSucceed(): void
    {
        $exception = new ValidationHttpException('', new ValidationException([
            new ConstraintViolation('field', 'This field is not valid.'),
        ]));

        $json = $this->serializer->serialize($exception, JsonEncoder::FORMAT);

        $this->assertSame('{"message":"","code":0,"violations":[{"propertyPath":"field","message":"This field is not valid."}]}', $json);
    }
}
