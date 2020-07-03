<?php

declare(strict_types=1);

namespace App\Services\QueryModifier\User;

use App\Services\QueryModifier\QueryModifier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

/**
 * Class UserQueryModifier
 * @package App\Services\QueryModifier\User
 */
class UserQueryModifier extends QueryModifier implements UserQueryModifierContract
{
    use ProvidesConvenienceMethods;

    /**
     * @inheritDoc
     */
    public function search(Builder $queries): void
    {
        $queries->when($this->request->get('searchPhrase'), static function (Builder $query, $value) {
            $query->having('full_name', 'like', '%' . $value . '%');
        });
    }

    /**
     * @param Builder $queries
     */
    public function ignoreCurrentUser(Builder $queries): void
    {
        $user = $this->request->user();

        if ($user) {
            $queries->where('users.id', '!=', $user->getKey());
        }
    }

    /**
     * @inheritDoc
     * @throws ValidationException
     */
    public function modify(Builder $query)
    {
        $this->search($query);
        $this->ignoreCurrentUser($query);
        $this->filter($query);
        $this->sort($query);
    }

    /**
     * @inheritDoc
     * @throws ValidationException
     */
    public function filter(Builder $queries): void
    {
        $attributes = $this->validate($this->request, $this->getFilterValidationRules());

        foreach ($attributes as $key => $value) {
            $queries->where($key, '=', $value);
        }
    }

    /**
     * @return array|string[]
     */
    private function getFilterValidationRules(): array
    {
        return [
            'job_title' => 'nullable|string',
            'focus' => 'nullable|string',
        ];
    }

    /**
     * @inheritDoc
     * @throws ValidationException
     */
    public function sort(Builder $queries): void
    {
        $attributes = $this->validate($this->request, $this->getSortValidationRules());

        if (isset($attributes['sort_column'])) {
            $queries->orderBy($attributes['sort_column'], $this->getDirectory($attributes['sort_direction'] ?? 'desc'));
        }
    }

    /**
     * @param string|null $directory
     * @return string
     */
    private function getDirectory(string $directory): string
    {
        $map = [
            'ascend' => 'asc',
            'descend' => 'desc',
        ];

        return $map[$directory] ?? 'desc';
    }

    /**
     * @return array
     */
    private function getSortValidationRules(): array
    {
        return [
            'sort_column' => 'nullable|in:full_name,rating',
            'sort_direction' => 'nullable|in:ascend,descend',
        ];
    }
}
