<?php

use App\Models\Profile;
use App\Queries\ReviewQueries;
use Illuminate\Database\Seeder;

/**
 * Class ProfileRatingSeeder
 */
class ProfileRatingSeeder extends Seeder
{
    /** @var ReviewQueries */
    private $queries;

    /**
     * ProfileRatingSeeder constructor.
     * @param ReviewQueries $queries
     */
    public function __construct(ReviewQueries $queries)
    {
        $this->queries = $queries;
    }

    public function run()
    {
        $profiles = Profile::query()->where('rating', '=', 0)->cursor();

        foreach ($profiles as $profile) {
            $rating = $this->queries->getAVGRatingByUserId($profile->user_id);

            if (isset($rating->rating)) {
                $profile->update([
                    'rating' => $rating->rating,
                ]);
            }
        }
    }
}
