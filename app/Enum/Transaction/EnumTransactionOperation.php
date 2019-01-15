<?php

declare(strict_types=1);

namespace App\Enum\Transaction;

use MabeEnum\Enum as BaseEnum;

/**
 * Class EnumTransactionOperation
 *
 * @package App\Enum\Transaction
 */
final class EnumTransactionOperation extends BaseEnum
{
    const DEPOSIT = 'deposit';
    const WITHDRAW = 'withdraw';
}