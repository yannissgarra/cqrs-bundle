<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Serializer\Normalizer;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
interface NormalizerAwareInterface
{
    public function setNormalizer(NormalizerInterface $normalizer): void;
}
