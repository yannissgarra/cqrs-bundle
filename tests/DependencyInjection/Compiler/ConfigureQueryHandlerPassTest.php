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
use Webmunkeez\CQRSBundle\DependencyInjection\Compiler\ConfigureQueryHandlerPass;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query\TestReadQueryHandler;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ConfigureQueryHandlerPassTest extends TestCase
{
    private ConfigureQueryHandlerPass $pass;

    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->pass = new ConfigureQueryHandlerPass();
        $this->container = new ContainerBuilder();
    }

    public function testProcessShouldSucceed(): void
    {
        $queryHandler = new Definition(TestReadQueryHandler::class);
        $queryHandler->addTag('webmunkeez_cqrs.query_handler');
        $this->container->setDefinition(TestReadQueryHandler::class, $queryHandler);

        $this->expectNotToPerformAssertions();

        $this->pass->process($this->container);
    }
}
