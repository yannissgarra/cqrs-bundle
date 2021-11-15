<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestCommand;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller\CommandAction;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class CommandActionTest extends KernelTestCase
{
    public function testInvoke(): void
    {
        self::bootKernel();

        $action = static::getContainer()->get(CommandAction::class);
        $response = $action->__invoke(TestCommand::NAME);

        $this->assertEquals(TestCommand::NAME, $response);
    }

    public function testInvokeException(): void
    {
        self::bootKernel();

        $action = static::getContainer()->get(CommandAction::class);

        $this->expectException(TestException::class);

        $action->__invoke(TestCommand::NAME_FAILED);
    }
}
