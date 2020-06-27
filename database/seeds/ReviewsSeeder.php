<?php

declare(strict_types=1);

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class ReviewsSeeder
 */
class ReviewsSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        if (Review::query()->count() > 0) {
            return;
        }

        foreach (User::query()->cursor() as $user) {
            /** @var User $user */

            for ($i = 0; $i < 20; $i++) {
                \factory(Review::class)->create([
                    'user_id' => $user->getKey(),
                    'author_id' => $this->getAuthorId(),
                ]);
            }
        }
    }

    /**
     * @return mixed
     */
    private function getAuthorId()
    {
        $user = factory(User::class)->create();

        return $user->getKey();
    }
}
