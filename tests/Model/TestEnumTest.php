<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Model;

use PHPUnit\Framework\TestCase;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\TestEnum;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestEnumTest extends TestCase
{
    public function testGetTranslationKeyShouldSucceed(): void
    {
        $this->assertSame('test.value1', TestEnum::VALUE1->getTranslationKey());
    }

    public function testGetChoicesShouldSucceed(): void
    {
        $this->assertEqualsCanonicalizing([1, 2], TestEnum::getChoices());
    }

    public function testGetNameChoicesShouldSucceed(): void
    {
        $this->assertEqualsCanonicalizing(['VALUE1', 'VALUE2'], TestEnum::getNameChoices());
    }

    public function testTryFromNameShouldSucceed(): void
    {
        $this->assertEquals(TestEnum::VALUE1, TestEnum::tryFromName('VALUE1'));
        $this->assertNull(TestEnum::tryFromName('VALUE3'));
    }

    public function testFromNameShouldSucceed(): void
    {
        $this->assertEquals(TestEnum::VALUE1, TestEnum::fromName('VALUE1'));
    }

    public function testFromNameWithNotExistingValueShouldThrowException(): void
    {
        $this->expectException(\ValueError::class);

        TestEnum::fromName('VALUE3');
    }
}
