<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Webmunkeez\CQRSBundle\Validator\Validator;
use Webmunkeez\CQRSBundle\Validator\ValidatorInterface;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(Validator::class)
            ->args([service('validator')])
        ->set(ValidatorInterface::class)
            ->alias(ValidatorInterface::class, Validator::class);
};
