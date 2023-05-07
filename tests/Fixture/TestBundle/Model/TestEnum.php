<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Test\Fixture\TestBundle\Model;

use Webmunkeez\CQRSBundle\Model\BackedEnumInterface;
use Webmunkeez\CQRSBundle\Model\BackedEnumTrait;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
enum TestEnum: int implements BackedEnumInterface
{
    use BackedEnumTrait;

    case VALUE1 = 1;
    case VALUE2 = 2;

    public static function getBaseTranslationMessage(): string
    {
        return 'test';
    }
}
