<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Webmunkeez\CQRSBundle\Exception\ValidationException;
use Webmunkeez\CQRSBundle\Exception\ValidationHttpException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ValidationHttpExceptionNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param ValidationHttpException $object
     *
     * @return array<string, mixed>
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        /** @var ValidationException $previous */
        $previous = $object->getPrevious();

        return [
            'message' => $object->getMessage(),
            'code' => $object->getCode(),
            'violations' => $this->normalizer->normalize($previous->getViolations(), $format, $context),
        ];
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof ValidationHttpException;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [ValidationHttpException::class => true];
    }
}
