<?php

declare(strict_types=1);

namespace App\Services\Reviews;

use App\Models\Reviews\Review;
use App\Models\User;
use App\Services\Validation\Rules\ReviewRules;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Class CreateReviewService
 * @package App\Services\Reviews
 */
class CreateReviewService
{
    /**
     * @return array
     */
    public function getValidationRules(): array
    {
        return (new ReviewRules())
            ->getRules();
    }

    /**
     * @param User $user
     * @param Authenticatable $currentUser
     * @param array $attributes
     * @return void
     */
    public function create(User $user, Authenticatable $currentUser, array $attributes): void
    {
        $ratingAttributes = array_filter($attributes, static function ($value) {
            return is_numeric($value) && ($value <= 5 || 0 >= $value);
        });

        app('db')->transaction(function () use ($attributes, $ratingAttributes, $currentUser, $user) {
            /** @var Review $review */
            $review = Review::query()
                ->create([
                    'user_id' => $user->getKey(),
                    'author_id' => $currentUser->getAuthIdentifier(),
                    'rating' => $this->calculateRating($ratingAttributes),
                ]);

            $review->reviewAttributes()->createMany(
                $this->getAttributes($attributes)
            );
        });
    }

    /**
     * @param array $attributes
     * @return float|int
     */
    private function calculateRating(array $attributes)
    {
        return array_sum($attributes);
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function getAttributes(array $attributes): array
    {
        $newAttributes = [];
        foreach ($attributes as $key => $value) {
            $newAttributes[] = ['name' => $key, 'value' => $value];
        }

        return $newAttributes;
    }
}
