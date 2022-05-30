<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Command;

use Webmunkeez\CQRSBundle\Command\AbstractCommandHandler;
use Webmunkeez\CQRSBundle\Exception\ValidationException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestCreatedEvent;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\Test;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestCreateCommandHandler extends AbstractCommandHandler
{
    /**
     * @throws ValidationException
     */
    public function handle(TestCreateCommand $command): void
    {
        $this->validate($command);

        $entity = (new Test())
            ->setId($command->getId())
            ->setTitle($command->getTitle());

        $this->validate($entity);

        $this->persist($entity);
        $this->flush();

        $event = (new TestCreatedEvent())
            ->setId($entity->getId())
            ->setTitle($entity->getTitle());

        $this->validate($event);

        $this->dispatch($event);
    }
}
