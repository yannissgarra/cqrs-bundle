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
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestCreateCommand;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command\TestCreateCommandHandler;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestCreateAction
{
    private TestCreateCommandHandler $handler;

    public function __construct(TestCreateCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Uuid $id, ?string $title = null): void
    {
        $command = (new TestCreateCommand())
            ->setId($id);

        if (null !== $title) {
            $command->setTitle($title);
        }

        $this->handler->handle($command);
    }
}
