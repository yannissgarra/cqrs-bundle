<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Model;

use Symfony\Component\Uid\Uuid;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
interface EntityInterface
{
    final public const UUID_REGEX = '^[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12}$';
    final public const SLUG_REGEX = '^[a-z0-9]+(?:-[a-z0-9]+)*$';

    public function getId(): Uuid;
}
