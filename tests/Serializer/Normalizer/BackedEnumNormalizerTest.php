<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Serializer\Normalizer;

use PHPUnit\Framework\TestCase;
use Webmunkeez\CQRSBundle\Serializer\Normalizer\BackedEnumNormalizer;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\TestEnum;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class BackedEnumNormalizerTest extends TestCase
{
    private BackedEnumNormalizer $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new BackedEnumNormalizer();
    }

    public function testNormalizeShouldSucceed(): void
    {
        $data = $this->normalizer->normalize(TestEnum::VALUE1);

        $this->assertSame('VALUE1', $data);
    }
}
