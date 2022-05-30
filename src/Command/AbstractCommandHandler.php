<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Command;

use Webmunkeez\CQRSBundle\Doctrine\EntityManagerAwareInterface;
use Webmunkeez\CQRSBundle\Doctrine\EntityManagerAwareTrait;
use Webmunkeez\CQRSBundle\Event\EventDispatcherAwareInterface;
use Webmunkeez\CQRSBundle\Event\EventDispatcherAwareTrait;
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
}
