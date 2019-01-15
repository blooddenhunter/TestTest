<?php

declare(strict_types=1);

namespace App\Console\Commands\Transaction;

use App\Enum\Client\EnumClientStatus;
use App\Enum\Transaction\EnumTransactionOperation;
use App\Enum\Transaction\EnumTransactionType;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Console\Command;

/**
 * Class Monthly
 *
 * @package App\Console\Commands\Transaction
 */
class Monthly extends Command
{
    /**
     *
     */
    const SUM = 10;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly fee';

    /**
     * @var Client
     */
    protected $client;

    /**
     * Monthly constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;

        parent::__construct();
    }

    /**
     *
     */
    public function handle() : void
    {
        $activeClients = $this->client
            ->lastMonthPassed()
            ->whereIn('status', [EnumClientStatus::ACTIVE, EnumClientStatus::INACTIVE])
            ->where('balance', '>=', self::SUM)
            ->get();

        foreach ($activeClients as $client) {
            $client->transaction()->save(
                new Transaction(
                    [
                        'operation' => EnumTransactionOperation::WITHDRAW,
                        'type'      => EnumTransactionType::REGULAR,
                        'sum'       => self::SUM
                    ]
                )
            );
        }
    }
}
