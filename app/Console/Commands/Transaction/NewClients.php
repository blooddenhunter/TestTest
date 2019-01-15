<?php

declare(strict_types=1);

namespace App\Console\Commands\Transaction;

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
class NewClients extends Command
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
    protected $signature = 'transaction:new-clients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create transaction new clients';

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
        $clients = $this->client
            ->whereDoesntHave('transaction', function ($query) {
                $query->where('type', EnumTransactionType::FIRST);
            })
            ->where('balance', '>=', self::SUM)
            ->get();

        foreach ($clients as $client) {
            $client->transaction()->save(
                new Transaction(
                    [
                        'operation' => EnumTransactionOperation::WITHDRAW,
                        'type'      => EnumTransactionType::FIRST,
                        'sum'       => self::SUM
                    ]
                )
            );
        }
    }
}