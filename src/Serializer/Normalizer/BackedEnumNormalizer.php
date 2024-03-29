<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmunkeez\CQRSBundle\Model\BackedEnumInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class BackedEnumNormalizer implements NormalizerInterface
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param BackedEnumInterface $object
     *
     * @return array<string, string>
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        return [
            'name' => $object->name,
            'title' => $this->translator->trans($object->getTranslationKey()),
            'value' => $object->value,
        ];
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof BackedEnumInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [BackedEnumInterface::class => true];
    }
}
