<?php
use App\Models\ProgramStudi;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
$factory->define(App\Models\ProgramStudi::class, function (Faker\Generator $faker) {
    return [
        'nama' => $faker->name,
        'deskripsi' => $faker->sentence($nbWords = 6, $variableNbWords = true)
    ];
});

$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'display_name' => $faker->word,
        'description' => $faker->sentence($nbWords = 6, $variableNbWords = true)
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'program_studi_id' => 1,
        'roles_id' => 1,
        'name' => $faker->name,
        'username' => $faker->word,
        'email' => $faker->email,
        'password' => bcrypt('secret'),
        'remember_token' => str_random(10),
        'status' => 'admin',
    ];
});
