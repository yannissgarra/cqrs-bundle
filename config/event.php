<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Webmunkeez\CQRSBundle\Event\EventDispatcher;
use Webmunkeez\CQRSBundle\Event\EventDispatcherInterface;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(EventDispatcher::class)
            ->args([service('event_dispatcher')])

        ->set(EventDispatcherInterface::class)

        ->alias(EventDispatcherInterface::class, EventDispatcher::class);
};
