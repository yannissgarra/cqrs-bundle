<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Webmunkeez\CQRSBundle\DependencyInjection\Compiler\ConfigureCommandHandlerPass;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestCreateCommandHandler;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ConfigureCommandHandlerPassTest extends TestCase
{
    private ConfigureCommandHandlerPass $pass;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->pass = new ConfigureCommandHandlerPass();
        $this->container = new ContainerBuilder();
    }

    public function testProcessShouldSucceed(): void
    {
        $commandHandler = new Definition(TestCreateCommandHandler::class);
        $commandHandler->addTag('webmunkeez_cqrs.command_handler');
        $this->container->setDefinition(TestCreateCommandHandler::class, $commandHandler);

        $this->expectNotToPerformAssertions();

        $this->pass->process($this->container);
    }
}
