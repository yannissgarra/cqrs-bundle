<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Serializer\Normalizer;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class Normalizer implements NormalizerInterface
{
    /**
     * @var Serializer
     */
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function denormalize(mixed $data, string $type): mixed
    {
        return $this->serializer->denormalize($data, $type);
    }
}
