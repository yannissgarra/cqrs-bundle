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
use Webmunkeez\CQRSBundle\DependencyInjection\Compiler\ConfigureEventListenerPass;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestCreatedEvent;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestCreatedEventListener;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ConfigureEventListenerPassTest extends TestCase
{
    private ConfigureEventListenerPass $pass;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->pass = new ConfigureEventListenerPass();
        $this->container = new ContainerBuilder();
    }

    public function testProcessShouldSucceed(): void
    {
        $eventListener = new Definition(TestCreatedEventListener::class);
        $eventListener->addTag('webmunkeez_cqrs.event_listener');
        $this->container->setDefinition(TestCreatedEventListener::class, $eventListener);

        $this->pass->process($this->container);

        $this->assertTrue($eventListener->hasTag('kernel.event_listener'));
        $this->assertCount(2, $eventListener->getTag('kernel.event_listener'));
        $this->assertSame(TestCreatedEvent::class, $eventListener->getTag('kernel.event_listener')[0]['event']);
        $this->assertSame('onTestCreatedEvent', $eventListener->getTag('kernel.event_listener')[0]['method']);
        $this->assertSame(TestCreatedEvent::class, $eventListener->getTag('kernel.event_listener')[1]['event']);
        $this->assertSame('onTestCreatedEvent2', $eventListener->getTag('kernel.event_listener')[1]['method']);
    }
}
