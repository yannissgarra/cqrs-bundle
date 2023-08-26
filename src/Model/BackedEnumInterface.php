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
interface BackedEnumInterface
{
    public static function getBaseTranslationKey(): string;

    public function getTranslationKey(): string;

    /**
     * @return array<int|string>
     */
    public static function getChoices(): array;

    /**
     * @return array<string>
     */
    public static function getNameChoices(): array;

    public static function tryFromName(string $name): ?static;

    /**
     * @throws \ValueError
     */
    public static function fromName(string $name): static;
}
