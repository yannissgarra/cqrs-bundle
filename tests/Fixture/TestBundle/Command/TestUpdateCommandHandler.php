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
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestUpdatedEvent;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestNotFoundException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Repository\TestWriteRepository;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestUpdateCommandHandler extends AbstractCommandHandler
{
    private TestWriteRepository $repository;

    public function __construct(TestWriteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws TestNotFoundException
     * @throws ValidationException
     */
    public function handle(TestUpdateCommand $command): void
    {
        $this->validate($command);

        $entity = $this->repository->findOneBy(['id' => $command->getId()]);

        if (null === $entity) {
            throw new TestNotFoundException();
        }

        $entity->setTitle($command->getTitle());

        $this->validate($entity);

        $this->flush();

        $event = (new TestUpdatedEvent())
            ->setId($entity->getId())
            ->setTitle($entity->getTitle());

        $this->validate($event);

        $this->dispatch($event);
    }
}
