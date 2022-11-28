<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webmunkeez\CQRSBundle\Event\AbstractEvent;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ConfigureEventHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        foreach ($container->findTaggedServiceIds('webmunkeez_cqrs.event_handler') as $eventHandlerId => $tags) {
            $definition = $container->findDefinition($eventHandlerId);

            $eventHandlerReflectionClass = $container->getReflectionClass($definition->getClass());

            if (false === $eventHandlerReflectionClass->hasMethod('handle')) {
                throw new \RuntimeException(sprintf('Invalid service "%s": must have an "handle()" method.', $eventHandlerId));
            }

            if (1 !== count($eventHandlerReflectionClass->getMethod('handle')->getParameters())) {
                throw new \RuntimeException(sprintf('Invalid service "%s": "handle()" method must have only one parameter.', $eventHandlerId));
            }

            $eventReflectionClass = new \ReflectionClass($eventHandlerReflectionClass->getMethod('handle')->getParameters()[0]->getType()->getName());

            if (false === $eventReflectionClass->isSubclassOf(new \ReflectionClass(AbstractEvent::class))) {
                throw new \RuntimeException(sprintf('Invalid service "%s": "handle()" method parameter must extends AbstractEvent.', $eventHandlerId));
            }

            $definition->addTag('kernel.event_listener', ['event' => $eventReflectionClass->getName(), 'method' => 'handle']);
        }
    }
}
