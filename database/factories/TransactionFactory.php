<?php

use Faker\Generator as Faker;
use App\Models\Transaction;
use App\Enum\Transaction\EnumTransactionStatus;
use App\Enum\Transaction\EnumTransactionType;
use App\Enum\Transaction\EnumTransactionOperation;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Transaction::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween('-3 years','now');

    return [
        'type' => $faker->randomElement(EnumTransactionType::getValues()),
        'sum' => 10,
        'status' => $faker->randomElement([EnumTransactionStatus::SUCCESS, EnumTransactionStatus::FAILED]),
        'operation' => $faker->randomElement(EnumTransactionOperation::getValues()),
        'created_at' => $date,
        'updated_at' => $date
    ];
});
