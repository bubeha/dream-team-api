<?php

declare(strict_types=1);

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Seeder;
use Illuminate\Hashing\HashManager;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    private const PASSWORD = '12345678';

    /** @var DatabaseManager */
    private $databaseManager;

    /** @var HashManager */
    private $hashManager;

    /**
     * UsersTableSeeder constructor.
     * @param DatabaseManager $databaseManager
     * @param HashManager $hashManager
     */
    public function __construct(DatabaseManager $databaseManager, HashManager $hashManager)
    {
        $this->databaseManager = $databaseManager;
        $this->hashManager = $hashManager;
    }

    /**
     * Run seeder
     */
    public function run(): void
    {
        if ($this->databaseManager->table('users')->count() > 0) {
            return;
        }

        $faker = Faker\Factory::create();
        $now = Carbon::now();

        $this->insertAdminToDatabase($faker, $now);
    }

    /**
     * @param \Faker\Generator $faker
     * @param Carbon $now
     * @return void
     */
    private function insertAdminToDatabase(\Faker\Generator $faker, Carbon $now): void
    {
        User::create([
            'id' => 1,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => 'admin@example.com',
            'password' => '$2y$10$bk2o.4kOqcFMC6gqAAP8H.yURbc20ZsstVy2ZnH7d9CfWKRKejnLi',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
