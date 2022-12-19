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
use Symfony\Component\Uid\Uuid;
use Webmunkeez\CQRSBundle\Serializer\Normalizer\NormalizerInterface;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\TestDetail;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class NormalizerFunctionalTest extends KernelTestCase
{
    private NormalizerInterface $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = static::getContainer()->get(NormalizerInterface::class);
    }

    public function testDenormalizeShouldSucceed(): void
    {
        $data = [
            'id' => Uuid::v4()->toRfc4122(),
            'title' => 'This is a title',
            'created_at' => (new \DateTime())->setTime(13, 37)->format(\DateTime::ATOM),
        ];

        /** @var TestDetail $test */
        $test = $this->normalizer->denormalize($data, TestDetail::class);

        $this->assertInstanceOf(TestDetail::class, $test);
        $this->assertTrue($test->getId()->equals(Uuid::fromString($data['id'])));
        $this->assertSame($data['title'], $test->getTitle());
        $this->assertEquals(\DateTime::createFromFormat(\DateTime::ATOM, $data['created_at']), $test->getCreatedAt());
    }

    public function testNormalizeShouldSucceed(): void
    {
        $test = (new TestDetail())
            ->setId(Uuid::v4())
            ->setTitle('This is a title')
            ->setCreatedAt((new \DateTime())->setTime(13, 37));

        /** @var TestDetail $test */
        $data = $this->normalizer->normalize($test);

        $this->assertTrue(Uuid::fromString($data['id'])->equals($test->getId()));
        $this->assertSame($test->getTitle(), $data['title']);
        $this->assertEquals($test->getCreatedAt(), \DateTime::createFromFormat(\DateTime::ATOM, $data['created_at']));
    }
}
