<?php

declare(strict_types=1);

namespace App\Services\Reviews;

use App\Models\Reviews\Review;
use App\Models\User;
use App\Services\Validation\Rules\ReviewRules;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\DatabaseManager;
use Throwable;

/**
 * Class CreateReviewService
 * @package App\Services\Reviews
 */
class CreateReviewService
{
    /** @var ConnectionResolverInterface */
    private $dbManager;

    /**
     * CreateReviewService constructor.
     * @param DatabaseManager $manager
     */
    public function __construct(DatabaseManager $manager)
    {
        $this->dbManager = $manager;
    }

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
     * @return Review|null
     * @throws Throwable
     */
    public function create(User $user, Authenticatable $currentUser, array $attributes): ?Review
    {
        $this->dbManager->beginTransaction();

        try {
            /** @var Review $review */
            $review = $this->createReviewWithAttributes($user, $currentUser, $attributes);

            $this->dbManager->commit();

            return $review;
        } catch (Exception $exception) {
            $this->dbManager->rollBack();
        }

        return null;
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

    /**
     * @param User $user
     * @param Authenticatable $currentUser
     * @param array $attributes
     * @return Review|null
     */
    protected function createReviewWithAttributes(User $user, Authenticatable $currentUser, array $attributes): ?Review
    {
        /** @var Review $review */
        $review = Review::query()
            ->create([
                'user_id' => $user->getKey(),
                'author_id' => $currentUser->getAuthIdentifier(),
                'rating' => $this->calculateRating(
                    $this->getRattingAttributes($attributes)
                ),
            ]);

        $review->reviewAttributes()->createMany(
            $this->getAttributes($attributes)
        );

        return $review;
    }

    /**
     * @param array $attributes
     * @return array
     */
    protected function getRattingAttributes(array $attributes): array
    {
        return array_filter($attributes, static function ($value) {
            return is_numeric($value) && ($value <= 5 || 0 >= $value);
        });
    }
}
