<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Seeder;

/**
 * Class GenerateUsersTableSeeder
 */
class GenerateUsersTableSeeder extends Seeder
{
    /** @var DatabaseManager */
    private $databaseManager;

    /**
     * GenerateUsersTableSeeder constructor.
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if ($this->databaseManager->table('users')->count() > 1) {
            return;
        }

        $this->insertUsersToDatabase();
    }

    /**
     * @return void
     */
    private function insertUsersToDatabase(): void
    {
        $roles = Role::all();
        $roleIds = $roles->pluck('id')->toArray();

        factory(User::class, 30)
            ->create()
            ->each(static function ($user) use ($roleIds) {
                $roleKey = array_rand($roleIds);

                $user
                    ->roles()
                    ->attach($roleIds[$roleKey]);
            });
    }
}
