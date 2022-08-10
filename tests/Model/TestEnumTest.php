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
    public function testGetChoicesShouldSucceed(): void
    {
        $this->assertEqualsCanonicalizing(['VALUE1', 'VALUE2'], TestEnum::getChoices());
    }
}
