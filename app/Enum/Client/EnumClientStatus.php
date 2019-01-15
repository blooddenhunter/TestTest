<?php

declare(strict_types=1);

namespace App\Enum\Client;

use MabeEnum\Enum as BaseEnum;

/**
 * Class EnumClientStatus
 *
 * @package App\Enum\Client
 */
final class EnumClientStatus extends BaseEnum
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    const LOCKED = 'locked';
}