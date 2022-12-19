<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Validator;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Webmunkeez\CQRSBundle\Exception\ValidationException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\Test;
use Webmunkeez\CQRSBundle\Validator\ValidatorInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ValidatorFunctionalTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $entityManager = static::getContainer()->get('doctrine')->getManager();
        $metaData = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metaData);

        $this->validator = static::getContainer()->get(ValidatorInterface::class);
    }

    public function testValidateWithTitleShouldSucceed(): void
    {
        $test = (new Test())->setTitle('Test');

        $this->expectNotToPerformAssertions();

        $this->validator->validate($test);
    }

    public function testValidateWithoutTitleShouldFail(): void
    {
        $test = new Test();

        try {
            $this->validator->validate($test);
        } catch (ValidationException $e) {
            $this->assertCount(1, $e->getViolations());
            $this->assertSame('title', $e->getViolations()[0]->getPropertyPath());

            return;
        }

        $this->fail();
    }
}
