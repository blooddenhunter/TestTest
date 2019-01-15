<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enum\Client\EnumClientStatus;
use App\Enum\Transaction\EnumTransactionOperation;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

/**
 * Class TransactionJob
 *
 * @package App\Jobs
 */
class TransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * TransactionJob constructor.
     *
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() : void
    {
        $this->transaction->changeProcessingStatus();

        DB::beginTransaction();

        try {
            /** @var Client $client */
            $client = $this->transaction->client;

            if ($client->balance < $this->transaction->sum) {
                throw new \Exception('Balance has insufficient funds');
            }

            if($this->transaction->isFirstType()){
                $client->status = EnumClientStatus::ACTIVE;
            }

            if ($this->transaction->operation
                === EnumTransactionOperation::DEPOSIT
            ) {
                $client->deposit($this->transaction->sum);
            } else {
                $client->withdraw($this->transaction->sum);
            }

            $this->transaction->changeSuccessStatus();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $this->transaction->changeFailedStatus();

            if($this->transaction->isRegularType() && $client->isActive()){
                $client->status = EnumClientStatus::INACTIVE;
                $client->save();
            }
        }
    }
}
