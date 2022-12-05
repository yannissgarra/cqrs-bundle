<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Webmunkeez\CQRSBundle\Command\CommandValueResolver;
use Webmunkeez\CQRSBundle\Query\QueryValueResolver;

return function (ContainerConfigurator $container) {
    $container->services()
        ->set(CommandValueResolver::class)
            ->args([service('serializer')])
            ->tag('controller.argument_value_resolver', ['priority' => 150])

        ->set(QueryValueResolver::class)
            ->args([service('serializer')])
            ->tag('controller.argument_value_resolver', ['priority' => 150]);
};
