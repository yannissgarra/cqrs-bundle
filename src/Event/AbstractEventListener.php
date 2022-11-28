<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Event;

use Webmunkeez\CQRSBundle\Message\MessageDispatcherAwareInterface;
use Webmunkeez\CQRSBundle\Message\MessageDispatcherAwareTrait;
use Webmunkeez\CQRSBundle\Validator\ValidatorAwareInterface;
use Webmunkeez\CQRSBundle\Validator\ValidatorAwareTrait;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
abstract class AbstractEventListener implements EventListenerInterface, MessageDispatcherAwareInterface, ValidatorAwareInterface
{
    use MessageDispatcherAwareTrait;
    use ValidatorAwareTrait;
}
