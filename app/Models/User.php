<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeInterface;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use function app;

/**
 * Class User
 *
 * @package App\Models
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $image
 * @property Carbon $date_of_birth
 * @property Carbon $first_work_date
 * @property-read string $full_name
 * @property-read string $image_src
 * @property-read int $age
 * @property-read int $years_of_experience
 * @property-read Profile $profile
 * @property-read int|null $roles_count
 * @property-read Role[]|null $roles
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereDateOfBirth($value)
 * @method static Builder|User whereFirstWorkDate($value)
 * @method static Builder|User whereImage($value)
 * @uses \App\Models\User::roles();
 * @uses \App\Models\User::getFullNameAttribute();
 * @uses \App\Models\User::getAgeAttribute();
 * @uses \App\Models\User::getYearsOfExperienceAttribute();
 * @uses \App\Models\User::getImageSrcAttribute();
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'image',
        'date_of_birth',
        'first_work_date',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_name',
        'age',
        'years_of_experience',
        'image_src',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'first_work_date' => 'date',
    ];

    // JWT Subject

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    // Start Accessors Block

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return int
     */
    public function getAgeAttribute(): int
    {
        if ($this->date_of_birth instanceof DateTimeInterface) {
            return Carbon::now()->diff($this->date_of_birth)->y;
        }

        return 0;
    }

    /**
     * @return int
     */
    public function getYearsOfExperienceAttribute(): int
    {
        if ($this->first_work_date instanceof DateTimeInterface) {
            return Carbon::now()->diff($this->first_work_date)->y;
        }

        return 0;
    }

    /**
     * @return string
     */
    public function getImageSrcAttribute(): string
    {
        if (! $this->image) {
            $factory = app(Factory::class);
            $disk = $factory->disk('public');

            return $disk->url('avatars/default_profile.png');
        }

        return '';
    }

    // End Accessors Block

    // Start Relationships Block

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class)->withDefault([
            'job_title' => null,
            'social_links' => [],
            'short_description' => null,
        ]);
    }
    // End Relationships Block
}
