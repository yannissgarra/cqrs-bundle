<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Validator;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface as CoreValidatorInterface;
use Webmunkeez\CQRSBundle\Exception\ValidationException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\Test;
use Webmunkeez\CQRSBundle\Validator\Validator;
use Webmunkeez\CQRSBundle\Validator\ValidatorInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ValidatorTest extends TestCase
{
    /**
     * @var CoreValidatorInterface&MockObject
     **/
    private CoreValidatorInterface $coreValidator;

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        /** @var CoreValidatorInterface&MockObject $coreValidator */
        $coreValidator = $this->getMockBuilder(CoreValidatorInterface::class)->disableOriginalConstructor()->getMock();
        $this->coreValidator = $coreValidator;

        $this->validator = new Validator($this->coreValidator);
    }

    public function testValidateWithTitleShouldSucceed(): void
    {
        $this->coreValidator->method('validate')->willReturn(new ConstraintViolationList());

        $this->expectNotToPerformAssertions();

        $test = (new Test())->setTitle('Test');

        $this->validator->validate($test);
    }

    public function testValidateWithoutTitleShouldThrowException(): void
    {
        $this->coreValidator->method('validate')->willReturn(new ConstraintViolationList([
            new ConstraintViolation('Title should not be blank.', null, [], null, 'titleField', ''),
        ]));

        $test = new Test();

        try {
            $this->validator->validate($test);
        } catch (ValidationException $e) {
            $this->assertCount(1, $e->getViolations());
            $this->assertSame('title_field', $e->getViolations()[0]->getPropertyPath());

            return;
        }

        $this->fail();
    }
}
