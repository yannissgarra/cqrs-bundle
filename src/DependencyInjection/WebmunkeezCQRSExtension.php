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
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Webmunkeez\CQRSBundle\Doctrine\Repository\EntityManagerAwareInterface;
use Webmunkeez\CQRSBundle\Event\EventDispatcherAwareInterface;
use Webmunkeez\CQRSBundle\Messenger\MessengerEventDispatcher;
use Webmunkeez\CQRSBundle\Validator\Validator;
use Webmunkeez\CQRSBundle\Validator\ValidatorAwareInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class WebmunkeezCQRSExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('dispatchers.php');
        $loader->load('serializer.php');
        $loader->load('validator.php');

        $container->registerForAutoconfiguration(EntityManagerAwareInterface::class)
            ->addMethodCall('setEntityManager', [new Reference('doctrine.orm.entity_manager')]);

        $container->registerForAutoconfiguration(EventDispatcherAwareInterface::class)
            ->addMethodCall('setEventDispatcher', [new Reference(MessengerEventDispatcher::class)]);

        $container->registerForAutoconfiguration(ValidatorAwareInterface::class)
            ->addMethodCall('setValidator', [new Reference(Validator::class)]);
    }
}
