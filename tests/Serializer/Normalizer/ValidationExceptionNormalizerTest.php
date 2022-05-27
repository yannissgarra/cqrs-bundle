<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Serializer\Normalizer;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Webmunkeez\CQRSBundle\Exception\ValidationException;
use Webmunkeez\CQRSBundle\Exception\ValidationHttpException;
use Webmunkeez\CQRSBundle\Serializer\Normalizer\ValidationHttpExceptionNormalizer;
use Webmunkeez\CQRSBundle\Validator\ConstraintViolation;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ValidationExceptionNormalizerTest extends TestCase
{
    public const DATA = [
        'violation' => [
            'propertyPath' => 'field',
            'message' => 'This field is not valid.',
        ],
    ];

    /**
     * @var NormalizerInterface&MockObject
     **/
    private NormalizerInterface $coreNormalizer;

    private ValidationHttpExceptionNormalizer $normalizer;

    protected function setUp(): void
    {
        /** @var NormalizerInterface&MockObject $coreNormalizer */
        $coreNormalizer = $this->getMockBuilder(NormalizerInterface::class)->disableOriginalConstructor()->getMock();
        $this->coreNormalizer = $coreNormalizer;

        $this->normalizer = new ValidationHttpExceptionNormalizer();
        $this->normalizer->setNormalizer($this->coreNormalizer);
    }

    public function testNormalizeWithValidationHttpExceptionShouldSucceed(): void
    {
        $this->coreNormalizer->method('normalize')->willReturn([self::DATA['violation']]);

        $exception = new ValidationHttpException('', new ValidationException([
            new ConstraintViolation(self::DATA['violation']['propertyPath'], self::DATA['violation']['message']),
        ]));

        $data = $this->normalizer->normalize($exception);

        $this->assertSame('', $data['message']);
        $this->assertSame(0, $data['code']);
        $this->assertCount(1, $data['violations']);
        $this->assertSame(self::DATA['violation']['propertyPath'], $data['violations'][0]['propertyPath']);
        $this->assertSame(self::DATA['violation']['message'], $data['violations'][0]['message']);
    }
}
