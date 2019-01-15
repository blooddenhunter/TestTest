<?php

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Transaction;

/**
 * Class ClientSeeder
 */
class ClientSeeder extends Seeder
{
    public function run()
    {
        factory(Client::class, 100000)->create()->each(function (Client $client) {
            $client->transaction()->saveMany(factory(Transaction::class, 10)->make());
        });
    }
}