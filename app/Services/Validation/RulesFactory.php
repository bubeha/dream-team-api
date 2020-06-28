<?php

declare(strict_types=1);


namespace App\Services\Validation;

/**
 * Interface RulesFactory
 * @package App\Services\Validation\Rules
 */
interface RulesFactory
{
    /**
     * @return array
     */
    public function getRules(): array;
}
