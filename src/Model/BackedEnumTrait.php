<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Model;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
trait BackedEnumTrait
{
    /**
     * @return array<int|string>
     */
    public static function getChoices(): array
    {
        return array_map(fn (\BackedEnum $enum): int|string => $enum->value, self::cases());
    }
}
