<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Reviews\Review;

/**
 * Class ReviewChangesEvent
 * @package App\Events
 */
class ReviewChangesEvent extends Event implements ReviewChangesInterface
{
    /** @var Review */
    private $review;

    /**
     * Create a new event instance.
     * @param Review $review
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    /**
     * @inheritDoc
     */
    public function getReview(): Review
    {
        return $this->review;
    }
}
