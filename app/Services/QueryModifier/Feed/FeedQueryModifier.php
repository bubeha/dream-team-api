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
            $query->whereHas('user', static function (Builder $query) use ($value) {
                $query->where('first_name', 'like', '%' . $value . '%');
            })
                ->orWhereHas('user.profile', static function (Builder $query) use ($value) {
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
    public function filterByStatus(Builder $query): void
    {
        $query->when($this->request->get('status'), static function (Builder $query, $value) {
            $query->where('status', '=', $value);
        });
    }

    /**
     * @inheritDoc
     */
    public function modify(Builder $query)
    {
        $this->search($query);
        $this->filterByStatus($query);
    }
}
