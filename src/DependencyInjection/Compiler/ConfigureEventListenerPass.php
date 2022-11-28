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
final class ConfigureEventListenerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        foreach ($container->findTaggedServiceIds('webmunkeez_cqrs.event_listener') as $eventListenerId => $tags) {
            $definition = $container->findDefinition($eventListenerId);

            $eventListenerReflectionClass = $container->getReflectionClass($definition->getClass());

            foreach ($eventListenerReflectionClass->getMethods() as $reflectionMethod) {
                if (false === str_starts_with($reflectionMethod->getShortName(), 'on')) {
                    continue;
                }

                if (1 !== count($reflectionMethod->getParameters())) {
                    throw new \RuntimeException(sprintf('Invalid service "%s": method "%s()" must have only one parameter.', $eventListenerId, $reflectionMethod->getShortName()));
                }

                $eventReflectionClass = new \ReflectionClass($reflectionMethod->getParameters()[0]->getType()->getName());

                if (false === $eventReflectionClass->isSubclassOf(new \ReflectionClass(AbstractEvent::class))) {
                    throw new \RuntimeException(sprintf('Invalid service "%s": method "%s()" parameter must extends %s.', $eventListenerId, $reflectionMethod->getShortName(), AbstractEvent::class));
                }

                $definition->addTag('kernel.event_listener', ['event' => $eventReflectionClass->getName(), 'method' => $reflectionMethod->getShortName()]);
            }
        }
    }
}
