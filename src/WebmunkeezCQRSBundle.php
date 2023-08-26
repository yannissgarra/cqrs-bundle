<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Webmunkeez\CQRSBundle\DependencyInjection\Compiler\ConfigureCommandHandlerPass;
use Webmunkeez\CQRSBundle\DependencyInjection\Compiler\ConfigureEventListenerPass;
use Webmunkeez\CQRSBundle\DependencyInjection\Compiler\ConfigureQueryHandlerPass;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class WebmunkeezCQRSBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(DoctrineOrmMappingsPass::createAttributeMappingDriver(['Webmunkeez\CQRSBundle\Model'], [$this->getPath().'/Model'], reportFieldsWhereDeclared: true));

        $container->addCompilerPass(new ConfigureCommandHandlerPass());
        $container->addCompilerPass(new ConfigureEventListenerPass());
        $container->addCompilerPass(new ConfigureQueryHandlerPass());
    }
}
