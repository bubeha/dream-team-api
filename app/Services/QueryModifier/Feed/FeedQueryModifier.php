<?php

declare(strict_types=1);

namespace App\Services\QueryModifier\Feed;

use App\Services\QueryModifier\QueryModifier;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ReviewFeedQueryModifier
 * @package App\Services
 */
class FeedQueryModifier extends QueryModifier implements FeedQueryModifierContract
{
    /**
     * @inheritDoc
     */
    public function search(Builder $queries): void
    {
        $queries->when($this->request->get('searchPhrase'), static function (Builder $query, $value) {
            $query->whereHas('author', static function (Builder $query) use ($value) {
                $query->where('first_name', 'like', '%' . $value . '%');
                $query->orWhere('last_name', 'like', '%' . $value . '%');
            })
                ->orWhereHas('author.profile', static function (Builder $query) use ($value) {
                    $query->where('job_title', 'like', '%' . $value . '%');
                })
                ->orWhere('strong_personal_characteristics', 'like', '%' . $value . '%')
                ->orWhere('weak_sides', 'like', '%' . $value . '%')
                ->orWhere('other_comments', 'like', '%' . $value . '%');
        });
    }

    /**
     * @inheritDoc
     */
    public function filterByRating(Builder $query): void
    {
        $rating = $this->request->get('rating');

        $query->when($rating !== null, static function (Builder $query) use ($rating) {
            if ((int)$rating > 0) {
                $query->where('rating', '>', 0);
            }

            if ((int)$rating === 0) {
                $query->where('rating', '=', 0);
            }

            if ((int)$rating < 0) {
                $query->where('rating', '<', 0);
            }
        });
    }

    /**
     * @inheritDoc
     */
    public function modify(Builder $query)
    {
        $this->search($query);
        $this->filterByRating($query);
    }
}
