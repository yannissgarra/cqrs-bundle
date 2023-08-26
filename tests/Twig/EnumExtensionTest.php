<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Twig;

use PHPUnit\Framework\TestCase;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\TestEnum;
use Webmunkeez\CQRSBundle\Twig\EnumExtension;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class EnumExtensionTest extends TestCase
{
    private EnumExtension $extension;

    protected function setUp(): void
    {
        $this->extension = new EnumExtension();
    }

    public function testGetEnumCasesShouldSucceed(): void
    {
        $enumCases = $this->extension->getEnumCases(TestEnum::class);

        $this->assertCount(2, $enumCases);
        $this->assertEquals(TestEnum::VALUE1, $enumCases[0]);
        $this->assertEquals(TestEnum::VALUE2, $enumCases[1]);
    }

    public function testGetEnumTranslationKeyShouldSucceed(): void
    {
        $enumTranslationKey = $this->extension->getEnumTranslationKey(TestEnum::VALUE1);

        $this->assertSame('test.value1', $enumTranslationKey);
    }
}
