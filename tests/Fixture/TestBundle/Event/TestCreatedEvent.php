<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event;

use Webmunkeez\CQRSBundle\Event\AbstractEvent;
use Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model\Test;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestCreatedEvent extends AbstractEvent
{
    private Test $test;

    public function __construct(Test $test)
    {
        $this->test = $test;
    }

    public function getTest(): Test
    {
        return $this->test;
    }
}
