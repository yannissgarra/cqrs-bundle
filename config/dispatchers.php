<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Webmunkeez\CQRSBundle\Event\EventDispatcherInterface;
use Webmunkeez\CQRSBundle\Messenger\MessengerEventDispatcher;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(MessengerEventDispatcher::class)
            ->args([service('messenger.bus.default')])

        ->set(EventDispatcherInterface::class)

        ->alias(EventDispatcherInterface::class, MessengerEventDispatcher::class);
};
