<?php

declare(strict_types=1);

namespace App\Enum\Transaction;

use MabeEnum\Enum as BaseEnum;

/**
 * Class EnumTransactionType
 *
 * @package App\Enum\Transaction
 */
final class EnumTransactionType extends BaseEnum
{
    const FIRST = 'first';
    const DEFAULT = 'default';
    const REGULAR = 'regular';
    const REFUND = 'refund';
}