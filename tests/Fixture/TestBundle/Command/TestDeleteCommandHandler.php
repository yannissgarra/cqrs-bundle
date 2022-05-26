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
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event\TestDeletedEvent;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception\TestNotFoundException;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Repository\TestWriteRepository;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestDeleteCommandHandler extends AbstractCommandHandler
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
    public function handle(TestDeleteCommand $command): void
    {
        $this->validate($command);

        $entity = $this->repository->findOneBy(['id' => $command->getId()]);

        if (null === $entity) {
            throw new TestNotFoundException();
        }

        $this->remove($entity);

        $this->flush();

        $event = (new TestDeletedEvent())
            ->setId($entity->getId());

        $this->validate($event);

        $this->dispatch($event);
    }
}
