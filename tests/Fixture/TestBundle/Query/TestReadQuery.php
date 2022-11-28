<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Webmunkeez\CQRSBundle\Query\AbstractQuery;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestReadQuery extends AbstractQuery
{
    #[Assert\NotBlank]
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
