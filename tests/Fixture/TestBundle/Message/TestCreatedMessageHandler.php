<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Message;

use Webmunkeez\CQRSBundle\Message\AbstractMessageHandler;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestCreatedMessageHandler extends AbstractMessageHandler
{
    public function handle(TestCreatedMessage $message): void
    {
    }
}
