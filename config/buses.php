<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Webmunkeez\CQRSBundle\Command\CommandBusInterface;
use Webmunkeez\CQRSBundle\Event\EventBusInterface;
use Webmunkeez\CQRSBundle\Messenger\CommandBus;
use Webmunkeez\CQRSBundle\Messenger\EventBus;
use Webmunkeez\CQRSBundle\Messenger\ExceptionMiddleware;
use Webmunkeez\CQRSBundle\Messenger\QueryBus;
use Webmunkeez\CQRSBundle\Query\QueryBusInterface;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(CommandBus::class)
            ->args([service('messenger.bus.command')])
        ->set(CommandBusInterface::class)
            ->alias(CommandBusInterface::class, CommandBus::class)
        ->set(QueryBus::class)
            ->args([service('messenger.bus.query')])
        ->set(QueryBusInterface::class)
            ->alias(QueryBusInterface::class, QueryBus::class)
        ->set(EventBus::class)
            ->args([service('messenger.bus.event')])
        ->set(EventBusInterface::class)
            ->alias(EventBusInterface::class, EventBus::class)
        ->set(ExceptionMiddleware::class);
};
