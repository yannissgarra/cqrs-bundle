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
use Webmunkeez\CQRSBundle\Query\AbstractQuery;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ConfigureQueryHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        foreach ($container->findTaggedServiceIds('webmunkeez_cqrs.query_handler') as $queryHandlerId => $tags) {
            $definition = $container->findDefinition($queryHandlerId);

            $queryHandlerReflectionClass = $container->getReflectionClass($definition->getClass());

            if (false === $queryHandlerReflectionClass->hasMethod('handle')) {
                throw new \RuntimeException(sprintf('Invalid service "%s": must have an "handle()" method.', $queryHandlerId));
            }

            if (1 !== count($queryHandlerReflectionClass->getMethod('handle')->getParameters())) {
                throw new \RuntimeException(sprintf('Invalid service "%s": method "handle()" must have only one parameter.', $queryHandlerId));
            }

            $commandReflectionClass = new \ReflectionClass($queryHandlerReflectionClass->getMethod('handle')->getParameters()[0]->getType()->getName());

            if (false === $commandReflectionClass->isSubclassOf(new \ReflectionClass(AbstractQuery::class))) {
                throw new \RuntimeException(sprintf('Invalid service "%s": method "handle()" parameter must extends %s.', $queryHandlerId, AbstractQuery::class));
            }
        }
    }
}
