<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Validator;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Webmunkeez\CQRSBundle\Exception\ValidationException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\ValidationTest;
use Webmunkeez\CQRSBundle\Validator\Validator;
use Webmunkeez\CQRSBundle\Validator\ValidatorInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ValidatorTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->validator = static::getContainer()
            ->get(Validator::class);
    }

    public function testValidate(): void
    {
        $test = (new ValidationTest())
            ->setTitle('Test');

        $this->expectNotToPerformAssertions();

        $this->validator->validate($test);
    }

    public function testValidateFail(): void
    {
        $test = (new ValidationTest())
            ->setTitle('');

        $this->expectException(ValidationException::class);

        $this->validator->validate($test);
    }
}
