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
    public function getId(): Uuid;
}
