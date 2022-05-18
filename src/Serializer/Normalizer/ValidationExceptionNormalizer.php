<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Webmunkeez\CQRSBundle\Exception\ValidationException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ValidationExceptionNormalizer implements NormalizerInterface, NormalizerAwareInterface, CacheableSupportsMethodInterface
{
    use NormalizerAwareTrait;

    public function normalize($exception, string $format = null, array $context = []): array
    {
        return [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'violations' => $this->normalizer->normalize($exception->getViolations()),
        ];
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof ValidationException;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
