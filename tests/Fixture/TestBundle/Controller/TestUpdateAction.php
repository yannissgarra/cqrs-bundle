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
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestUpdateCommand;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestUpdateCommandHandler;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestUpdateAction
{
    private TestUpdateCommandHandler $handler;

    public function __construct(TestUpdateCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Uuid $id, ?string $title = null): void
    {
        $command = (new TestUpdateCommand())
            ->setId($id);

        if (null !== $title) {
            $command->setTitle($title);
        }

        $this->handler->handle($command);
    }
}
