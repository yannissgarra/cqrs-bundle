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
use Webmunkeez\CQRSBundle\Command\AbstractCommand;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class ConfigureCommandHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        foreach ($container->findTaggedServiceIds('webmunkeez_cqrs.command_handler') as $commandHandlerId => $tags) {
            $definition = $container->findDefinition($commandHandlerId);

            $commandHandlerReflectionClass = $container->getReflectionClass($definition->getClass());

            if (false === $commandHandlerReflectionClass->hasMethod('handle')) {
                throw new \RuntimeException(sprintf('Invalid service "%s": must have an "handle()" method.', $commandHandlerId));
            }

            if (1 !== count($commandHandlerReflectionClass->getMethod('handle')->getParameters())) {
                throw new \RuntimeException(sprintf('Invalid service "%s": method "handle()" must have only one parameter.', $commandHandlerId));
            }

            $commandReflectionClass = new \ReflectionClass($commandHandlerReflectionClass->getMethod('handle')->getParameters()[0]->getType()->getName());

            if (false === $commandReflectionClass->isSubclassOf(new \ReflectionClass(AbstractCommand::class))) {
                throw new \RuntimeException(sprintf('Invalid service "%s": method "handle()" parameter must extends %s.', $commandHandlerId, AbstractCommand::class));
            }
        }
    }
}
