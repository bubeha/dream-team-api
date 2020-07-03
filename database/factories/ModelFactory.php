<?php

// phpcs:disable

use App\Models\Profile;
use App\Models\Reviews\Attribute;
use App\Models\Reviews\Review;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var Factory $factory */

/**
 * @return array
 * @throws Exception
 */
function getTwoDates(): array
{
    $first = generateRandomDate(
        Carbon::create(1980, 1, 1),
        Carbon::create(2000, 1, 1)
    );

    $second = generateRandomDate(
        Carbon::create(1990, 1, 1),
        Carbon::now()
    );

    if ($first instanceof Carbon && $first->lessThan($second)) {
        return [$second, $first];
    }

    return [$first, $second];
}

$factory->define(User::class, static function (Faker $faker) {
    [$dateOrBirth, $firstWorkDate] = getTwoDates();

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->email,
        'image' => null,
        'password' => '$2y$10$bk2o.4kOqcFMC6gqAAP8H.yURbc20ZsstVy2ZnH7d9CfWKRKejnLi',
        'date_of_birth' => $dateOrBirth,
        'first_work_date' => $firstWorkDate,
    ];
});

$factory->afterCreating(User::class, static function (User $user) {
    $user->profile()->save(\factory(Profile::class)->make());
});

$factory->define(Profile::class, static function (Faker $faker) {
    return [
        'job_title' => $faker->jobTitle,
        'social_links' => [
            [
                'name' => 'github',
                'profile_name' => 'seba.bach',
                'link' => 'https://github.com/' . $faker->name,
            ],
            [
                'name' => 'slack',
                'profile_name' => '@bach777',
                'link' => 'https://' . $faker->name . 'slack.com',
            ],
            [
                'name' => 'linkedin',
                'profile_name' => $faker->name,
                'link' => 'https://www.linkedin.com/in/' . $faker->name,
            ],
        ],
        'short_description' => $faker->text(500),
    ];
});

$factory->define(Review::class, static function (Faker $faker) {
    return [
    ];
});

$factory->afterMaking(Attribute::class, static function (Faker $faker) {
    return [

    ];
});
