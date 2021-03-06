<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ReviewChangesInterface;
use App\Models\Profile;
use App\Queries\ReviewQueries;

/**
 * Class ChangeUserRatingListener
 * @package App\Listeners
 */
class ChangeUserRatingListener
{
    /** @var ReviewQueries */
    private $queries;

    /**
     * Create the event listener.
     *
     * @param ReviewQueries $queries
     */
    public function __construct(ReviewQueries $queries)
    {
        $this->queries = $queries;
    }

    /**
     * Handle the event.
     *
     * @param ReviewChangesInterface $event
     * @return void
     */
    public function handle(ReviewChangesInterface $event): void
    {
        $review = $event->getReview();

        $rating = $this->queries->getAVGRatingByUserId($review->user_id);

        if (isset($rating->rating)) {
            $profile = Profile::query()
                ->where('user_id', '=', $review->user_id)
                ->first();

            if ($profile) {
                $profile->update([
                    'rating' => $rating->rating,
                ]);
            }
        }
    }
}
