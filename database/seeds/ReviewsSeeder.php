<?php

declare(strict_types=1);

use App\Models\Review;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

/**
 * Class ReviewsSeeder
 */
class ReviewsSeeder extends Seeder
{
    private const STATUSES = [
        Review::NEGATIVE_STATUS,
        Review::NEUTRAL_STATUS,
        Review::POSITIVE_STATUS,
    ];

    /**
     * @return void
     */
    public function run(): void
    {
        $faker = Factory::create();

        foreach (User::query()->cursor() as $user) {
            /** @var User $user */

            for ($i = 0; $i < 20; $i++) {
                $randKey = array_rand(static::STATUSES);

                Review::query()->create([
                    'user_id' => $user->getKey(),
                    'author_id' => $this->getAuthorId(),
                    'strong_personal_characteristics' => $faker->text(255),
                    'weak_sides' => $faker->text(255),
                    'other_comments' => $faker->text(255),
                    'status' => static::STATUSES[$randKey],
                ]);
            }
        }
    }

    /**
     * @return mixed
     */
    private function getAuthorId()
    {
        return 1;
    }
}
