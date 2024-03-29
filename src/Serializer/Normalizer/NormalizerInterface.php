<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Serializer\Normalizer;

use Webmunkeez\CQRSBundle\Exception\NormalizationException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
interface NormalizerInterface
{
    /**
     * @throws NormalizationException
     */
    public function normalize(mixed $object): array;

    /**
     * @throws NormalizationException
     */
    public function denormalize(mixed $data, string $type): mixed;
}
