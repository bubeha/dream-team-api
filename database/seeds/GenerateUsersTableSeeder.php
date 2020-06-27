<?php

use App\Models\User;
use Carbon\Carbon;
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
        factory(User::class, 30)->create([
            'password' => '$2y$10$bk2o.4kOqcFMC6gqAAP8H.yURbc20ZsstVy2ZnH7d9CfWKRKejnLi',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
