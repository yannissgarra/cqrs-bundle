<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Event;

use Symfony\Component\Uid\Uuid;
use Webmunkeez\CQRSBundle\Event\EventInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestDeletedEvent implements EventInterface
{
    private Uuid $id;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }
}
