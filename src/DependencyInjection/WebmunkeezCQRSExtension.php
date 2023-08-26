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
use Webmunkeez\CQRSBundle\Command\CommandHandlerInterface;
use Webmunkeez\CQRSBundle\Doctrine\EntityManagerAwareInterface;
use Webmunkeez\CQRSBundle\Event\EventDispatcherAwareInterface;
use Webmunkeez\CQRSBundle\Event\EventDispatcherInterface;
use Webmunkeez\CQRSBundle\Event\EventListenerInterface;
use Webmunkeez\CQRSBundle\Message\MessageDispatcherAwareInterface;
use Webmunkeez\CQRSBundle\Message\MessageDispatcherInterface;
use Webmunkeez\CQRSBundle\Message\MessageHandlerInterface;
use Webmunkeez\CQRSBundle\Message\MessageInterface;
use Webmunkeez\CQRSBundle\Query\QueryHandlerInterface;
use Webmunkeez\CQRSBundle\Serializer\Normalizer\NormalizerAwareInterface;
use Webmunkeez\CQRSBundle\Serializer\Normalizer\NormalizerInterface;
use Webmunkeez\CQRSBundle\Validator\ValidatorAwareInterface;
use Webmunkeez\CQRSBundle\Validator\ValidatorInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class WebmunkeezCQRSExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../../config'), $container->getParameter('kernel.environment'));
        $loader->load('event.php');
        $loader->load('event_listener.php');
        $loader->load('message.php');
        $loader->load('serializer.php');
        $loader->load('twig.php');
        $loader->load('validator.php');
        $loader->load('value_resolver.php');

        $container->registerForAutoconfiguration(CommandHandlerInterface::class)
            ->addTag('webmunkeez_cqrs.command_handler');

        $container->registerForAutoconfiguration(EntityManagerAwareInterface::class)
            ->addMethodCall('setEntityManager', [new Reference('doctrine.orm.entity_manager')]);

        $container->registerForAutoconfiguration(EventDispatcherAwareInterface::class)
            ->addMethodCall('setEventDispatcher', [new Reference(EventDispatcherInterface::class)]);

        $container->registerForAutoconfiguration(EventListenerInterface::class)
            ->addTag('webmunkeez_cqrs.event_listener');

        $container->registerForAutoconfiguration(MessageDispatcherAwareInterface::class)
            ->addMethodCall('setMessageDispatcher', [new Reference(MessageDispatcherInterface::class)]);

        $container->registerForAutoconfiguration(MessageHandlerInterface::class)
            ->addTag('messenger.message_handler', ['method' => 'handle']);

        $container->registerForAutoconfiguration(QueryHandlerInterface::class)
            ->addTag('webmunkeez_cqrs.query_handler');

        $container->registerForAutoconfiguration(NormalizerAwareInterface::class)
            ->addMethodCall('setNormalizer', [new Reference(NormalizerInterface::class)]);

        $container->registerForAutoconfiguration(ValidatorAwareInterface::class)
            ->addMethodCall('setValidator', [new Reference(ValidatorInterface::class)]);
    }

    public function prepend(ContainerBuilder $container): void
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
                    MessageInterface::class => 'async',
                ],
            ],
        ]);
    }

    private function defineTransport(string $name, string $environment): array
    {
        if (true === in_array($environment, ['test'])) {
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
