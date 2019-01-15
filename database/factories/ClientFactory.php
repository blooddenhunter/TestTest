<?php

use Faker\Generator as Faker;
use App\Enum\Client\EnumClientStatus;
use App\Models\Client;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Client::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween('-3 years','now');

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'patronymic_name' => $faker->firstNameMale,
        'email' => $faker->unique()->safeEmail,
        'status' => $faker->randomElement(EnumClientStatus::getValues()),
        'balance' => random_int(0, 10000),
//        'last_payment' => $date,
        'created_at' => $date,
        'updated_at' => $date
    ];
});
