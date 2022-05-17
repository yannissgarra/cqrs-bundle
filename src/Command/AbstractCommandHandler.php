<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Command;

use Webmunkeez\CQRSBundle\Doctrine\Repository\EntityManagerAwareInterface;
use Webmunkeez\CQRSBundle\Doctrine\Repository\EntityManagerAwareTrait;
use Webmunkeez\CQRSBundle\Event\EventDispatcherAwareInterface;
use Webmunkeez\CQRSBundle\Event\EventDispatcherAwareTrait;
use Webmunkeez\CQRSBundle\Event\EventInterface;
use Webmunkeez\CQRSBundle\Model\EntityInterface;
use Webmunkeez\CQRSBundle\Validator\ValidatorAwareInterface;
use Webmunkeez\CQRSBundle\Validator\ValidatorAwareTrait;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
abstract class AbstractCommandHandler implements CommandHandlerInterface, EntityManagerAwareInterface, EventDispatcherAwareInterface, ValidatorAwareInterface
{
    use EntityManagerAwareTrait;
    use EventDispatcherAwareTrait;
    use ValidatorAwareTrait;

    protected function persist(EntityInterface $entity): void
    {
        $this->entityManager->persist($entity);
    }

    protected function remove(EntityInterface $entity): void
    {
        $this->entityManager->remove($entity);
    }

    protected function flush(): void
    {
        $this->entityManager->flush();
    }

    protected function dispatch(EventInterface $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }

    protected function validate(mixed $value): void
    {
        $this->validator->validate($value);
    }
}