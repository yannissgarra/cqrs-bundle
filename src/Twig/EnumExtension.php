<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Webmunkeez\CQRSBundle\Model\BackedEnumInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class EnumExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('enum_cases', [$this, 'getEnumCases']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('enum_trans_key', [$this, 'getEnumTranslationKey']),
        ];
    }

    public function getEnumCases(string $backedEnumClass): array
    {
        $reflection = new \ReflectionClass($backedEnumClass);

        if (false === $reflection->implementsInterface(BackedEnumInterface::class)) {
            throw new \InvalidArgumentException(sprintf('The enum must be a "'.BackedEnumInterface::class.'", "%s" given.', $backedEnumClass));
        }

        return $backedEnumClass::cases();
    }

    public function getEnumTranslationKey(BackedEnumInterface $backedEnum): string
    {
        return $backedEnum->getTranslationKey();
    }
}
