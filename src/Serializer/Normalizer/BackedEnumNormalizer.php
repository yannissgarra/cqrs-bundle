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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class BackedEnumNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    /**
     * @param \BackedEnum $object
     */
    public function normalize(mixed $object, string $format = null, array $context = []): string
    {
        return $object->name;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof \BackedEnum;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
