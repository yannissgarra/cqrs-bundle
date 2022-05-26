<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Controller;

use Symfony\Component\Uid\Uuid;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestDeleteCommand;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestDeleteCommandHandler;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestDeleteAction
{
    private TestDeleteCommandHandler $handler;

    public function __construct(TestDeleteCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Uuid $id): void
    {
        $command = (new TestDeleteCommand())
            ->setId($id);

        $this->handler->handle($command);
    }
}
