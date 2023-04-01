<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Serializer\Normalizer;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\TestEnum;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class BackedEnumNormalizerFunctionalTest extends KernelTestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = static::getContainer()->get('serializer');
    }

    public function testNormalizeShouldSucceed(): void
    {
        $json = $this->serializer->serialize(TestEnum::VALUE1, JsonEncoder::FORMAT);

        $this->assertSame('"VALUE1"', $json);
    }
}
