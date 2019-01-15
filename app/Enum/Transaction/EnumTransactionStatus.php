<?php

declare(strict_types=1);

namespace App\Enum\Transaction;

use MabeEnum\Enum as BaseEnum;

/**
 * Class EnumTransactionStatus
 *
 * @package App\Enum\Transaction
 */
final class EnumTransactionStatus extends BaseEnum
{
    const AWAIT = 'await';
    const PROCESSING = 'processing';
    const SUCCESS = 'success';
    const FAILED = 'failed';
}