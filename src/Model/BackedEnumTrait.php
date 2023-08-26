<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Model;

use Symfony\Component\String\UnicodeString;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
trait BackedEnumTrait
{
    public function getTranslationKey(): string
    {
        return (new UnicodeString(self::getBaseTranslationKey().'.'.$this->name))->lower()->toString();
    }

    /**
     * @return array<int|string>
     */
    public static function getChoices(): array
    {
        return array_map(fn (\BackedEnum $enum): int|string => $enum->value, self::cases());
    }

    /**
     * @return array<string>
     */
    public static function getNameChoices(): array
    {
        return array_map(fn (\BackedEnum $enum): string => $enum->name, self::cases());
    }

    public static function tryFromName(string $name): ?static
    {
        $reflection = new \ReflectionEnum(static::class);

        return $reflection->hasCase($name) ? $reflection->getCase($name)->getValue() : null;
    }

    /**
     * @throws \ValueError
     */
    public static function fromName(string $name): static
    {
        $case = self::tryFromName($name);

        if (null === $case) {
            throw new \ValueError($name.' is not a valid case for enum '.self::class);
        }

        return $case;
    }
}
