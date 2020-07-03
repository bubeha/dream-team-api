<?php

namespace App\Events;

use App\Models\Reviews\Review;

/**
 * Interface ReviewChangesInterface
 * @package App\Events
 */
interface ReviewChangesInterface
{
    /**
     * @return Review
     */
    public function getReview(): Review;
}
