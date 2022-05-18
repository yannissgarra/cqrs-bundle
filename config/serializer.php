<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Webmunkeez\CQRSBundle\Serializer\Normalizer\ValidationExceptionNormalizer;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(ValidationExceptionNormalizer::class)
            ->tag('serializer.normalizer');
};
