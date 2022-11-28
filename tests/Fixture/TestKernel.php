<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\TestBundle;
use Webmunkeez\CQRSBundle\WebmunkeezCQRSBundle;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        return [
            new DoctrineBundle(),
            new FrameworkBundle(),
            new WebmunkeezCQRSBundle(),
            new TestBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__.'/config/config.yaml');
        $loader->load(__DIR__.'/config/doctrine.yaml');
        $loader->load(__DIR__.'/config/messenger.yaml');
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }
}
