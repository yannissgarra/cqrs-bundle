<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Message;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
trait MessageDispatcherAwareTrait
{
    protected MessageDispatcherInterface $messageDispatcher;

    public function setMessageDispatcher(MessageDispatcherInterface $messageDispatcher): void
    {
        $this->messageDispatcher = $messageDispatcher;
    }

    protected function dispatch(MessageInterface $message): void
    {
        $this->messageDispatcher->dispatch($message);
    }
}
