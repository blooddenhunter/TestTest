<?php

declare(strict_types=1);

namespace App\Console\Commands\Transaction;

use App\Enum\Client\EnumClientStatus;
use App\Models\Client;
use Illuminate\Console\Command;

/**
 * Class InActiveClient
 *
 * @package App\Console\Commands\Transaction
 */
class InActiveClient extends Command
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
    protected $signature = 'transaction:inactive-clients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inactive clients';

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
        $this->client
            ->lastMonthPassed()
            ->whereIn('status', [EnumClientStatus::ACTIVE])
            ->where('balance', '<', self::SUM)
            ->update(['status' => EnumClientStatus::INACTIVE]);
    }
}
