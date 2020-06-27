<?php

declare(strict_types=1);

namespace App\Services\QueryModifier;

use Illuminate\Http\Request;

/**
 * Class QueryModifier
 * @package App\Services
 */
abstract class QueryModifier implements QueryModifierContract
{
    /** @var Request */
    protected $request;

    /**
     * QueryModifier constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
