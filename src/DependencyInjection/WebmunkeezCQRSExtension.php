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
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Webmunkeez\CQRSBundle\Doctrine\EntityManagerAwareInterface;
use Webmunkeez\CQRSBundle\Event\EventDispatcher;
use Webmunkeez\CQRSBundle\Event\EventDispatcherAwareInterface;
use Webmunkeez\CQRSBundle\Event\EventHandlerInterface;
use Webmunkeez\CQRSBundle\Validator\Validator;
use Webmunkeez\CQRSBundle\Validator\ValidatorAwareInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class WebmunkeezCQRSExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('event.php');
        $loader->load('event_listener.php');
        $loader->load('serializer.php');
        $loader->load('validator.php');

        $container->registerForAutoconfiguration(EntityManagerAwareInterface::class)
            ->addMethodCall('setEntityManager', [new Reference('doctrine.orm.entity_manager')]);

        $container->registerForAutoconfiguration(EventDispatcherAwareInterface::class)
            ->addMethodCall('setEventDispatcher', [new Reference(EventDispatcher::class)]);

        $container->registerForAutoconfiguration(EventHandlerInterface::class)
            ->addTag('webmunkeez_cqrs.event_handler');

        $container->registerForAutoconfiguration(ValidatorAwareInterface::class)
            ->addMethodCall('setValidator', [new Reference(Validator::class)]);
    }

    public function prepend(ContainerBuilder $container)
    {
        // define default config for messenger
        $container->prependExtensionConfig('framework', [
            'serializer' => [
                'name_converter' => 'serializer.name_converter.camel_case_to_snake_case',
            ],
            'messenger' => [
                'failure_transport' => 'failed',
                'transports' => [
                    'async' => $this->defineTransport('async', $container->getParameter('kernel.environment')),
                    'failed' => $this->defineTransport('failed', $container->getParameter('kernel.environment')),
                ],
                'routing' => [
                ],
            ],
        ]);
    }

    private function defineTransport(string $name, string $environment): array
    {
        if ('test' === $environment) {
            return [
                'dsn' => 'in-memory://',
            ];
        }

        return [
            'dsn' => 'doctrine://default',
            'options' => [
                'table_name' => 'msgr_message',
                'queue_name' => $name,
                'auto_setup' => 'false',
            ],
        ];
    }
}
