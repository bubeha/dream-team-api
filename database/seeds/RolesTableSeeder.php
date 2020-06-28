<?php

declare(strict_types=1);

use App\Models\Role;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Seeder;

/**
 * Class RolesTableSeeder
 */
class RolesTableSeeder extends Seeder // @codingStandardsIgnoreLine
{
    private const ROLES = [
        Role::MANAGER_ROLE,
        Role::EMPLOYER_ROLE,
    ];

    /** @var DatabaseManager */
    private $dbManager;

    /**
     * DatabaseSeeder constructor.
     * @param DatabaseManager $dbManager
     */
    public function __construct(DatabaseManager $dbManager)
    {
        $this->dbManager = $dbManager;
    }

    public function run(): void
    {
        $roles = $this->dbManager
            ->table('roles')
            ->pluck('name')
            ->toArray();

        $missingRoles = array_filter(static::ROLES, static function ($value) use ($roles) {
            return ! in_array($value, $roles, true);
        });

        foreach ($missingRoles as $role) {
            Role::query()->create([
                'name' => $role,
            ]);
        }
    }
}
