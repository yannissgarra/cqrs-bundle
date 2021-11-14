<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Webmunkeez\CQRSBundle\Command\CommandBusAwareInterface;
use Webmunkeez\CQRSBundle\Command\CommandHandlerInterface;
use Webmunkeez\CQRSBundle\Event\EventBusAwareInterface;
use Webmunkeez\CQRSBundle\Event\EventHandlerInterface;
use Webmunkeez\CQRSBundle\Messenger\CommandBus;
use Webmunkeez\CQRSBundle\Messenger\EventBus;
use Webmunkeez\CQRSBundle\Messenger\ExceptionMiddleware;
use Webmunkeez\CQRSBundle\Messenger\QueryBus;
use Webmunkeez\CQRSBundle\Query\QueryBusAwareInterface;
use Webmunkeez\CQRSBundle\Query\QueryHandlerInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class WebmunkeezCQRSExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('buses.xml');

        $container->registerForAutoconfiguration(CommandHandlerInterface::class)
            ->addTag('messenger.message_handler', ['bus' => 'messenger.bus.command'])
        ;

        $container->registerForAutoconfiguration(CommandBusAwareInterface::class)
            ->addMethodCall('setCommandBus', [$container->getDefinition(CommandBus::class)])
        ;

        $container->registerForAutoconfiguration(QueryHandlerInterface::class)
            ->addTag('messenger.message_handler', ['bus' => 'messenger.bus.query'])
        ;

        $container->registerForAutoconfiguration(QueryBusAwareInterface::class)
            ->addMethodCall('setQueryBus', [$container->getDefinition(QueryBus::class)])
        ;

        $container->registerForAutoconfiguration(EventHandlerInterface::class)
            ->addTag('messenger.message_handler', ['bus' => 'messenger.bus.event'])
        ;

        $container->registerForAutoconfiguration(EventBusAwareInterface::class)
            ->addMethodCall('setEventBus', [$container->getDefinition(EventBus::class)])
        ;
    }

    public function prepend(ContainerBuilder $container)
    {
        // define default config for messenger
        $container->prependExtensionConfig('framework', [
            'messenger' => [
                'default_bus' => 'messenger.bus.event',
                'buses' => [
                    'messenger.bus.command' => [
                        'middleware' => [
                            ExceptionMiddleware::class,
                        ],
                    ],
                    'messenger.bus.query' => [
                        'middleware' => [
                            ExceptionMiddleware::class,
                        ],
                    ],
                    'messenger.bus.event' => [
                        'default_middleware' => 'allow_no_handlers',
                        'middleware' => [
                            ExceptionMiddleware::class,
                        ],
                    ],
                ],
            ],
        ]);
    }
}
