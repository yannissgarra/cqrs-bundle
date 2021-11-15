<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Query;

use Webmunkeez\CQRSBundle\Query\QueryInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestQuery implements QueryInterface
{
    public const NAME = 'TestQuery';
    public const NAME_FAILED = 'TestQueryFailed';

    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
