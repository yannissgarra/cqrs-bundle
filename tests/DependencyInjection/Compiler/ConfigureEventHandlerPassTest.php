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
use Webmunkeez\CQRSBundle\DependencyInjection\Compiler\ConfigureEventHandlerPass;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestCreatedEvent;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestCreatedEventHandler;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ConfigureEventHandlerPassTest extends TestCase
{
    private ConfigureEventHandlerPass $pass;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->pass = new ConfigureEventHandlerPass();
        $this->container = new ContainerBuilder();
    }

    public function testProcessShouldSucceed(): void
    {
        $eventHandler = new Definition(TestCreatedEventHandler::class);
        $eventHandler->addTag('webmunkeez_cqrs.event_handler');
        $this->container->setDefinition(TestCreatedEventHandler::class, $eventHandler);

        $this->pass->process($this->container);

        $this->assertTrue($eventHandler->hasTag('kernel.event_listener'));
        $this->assertCount(1, $eventHandler->getTag('kernel.event_listener'));
        $this->assertSame(TestCreatedEvent::class, $eventHandler->getTag('kernel.event_listener')[0]['event']);
        $this->assertSame('handle', $eventHandler->getTag('kernel.event_listener')[0]['method']);
    }
}
