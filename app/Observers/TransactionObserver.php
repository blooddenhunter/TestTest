<?php

declare(strict_types=1);

namespace App\Observers;

use App\Jobs\TransactionJob;
use App\Models\Transaction;
use Illuminate\Contracts\Bus\Dispatcher;

/**
 * Class TransactionObserver
 *
 * @package App\Observers
 */
class TransactionObserver
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * TransactionObserver constructor.
     *
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Transaction $transaction
     */
    public function created(Transaction $transaction)
    {
        $this->dispatcher->dispatch(new TransactionJob($transaction));
    }
}
