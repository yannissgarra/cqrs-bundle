<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Exception;

use Webmunkeez\CQRSBundle\Exception\ModelNotFoundException;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class TestNotFoundException extends ModelNotFoundException
{
}
