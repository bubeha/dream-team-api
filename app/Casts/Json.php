<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Json
 * @package App\Casts
 */
class Json implements CastsAttributes
{

    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed|void
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return json_decode($value, true);
    }

    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return array|string|void
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode($value);
    }
}
