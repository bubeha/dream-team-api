<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Faker\Generator as Faker;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Seeder;
use Illuminate\Hashing\HashManager;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
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

        $faker = Factory::create();
        $now = Carbon::now();

        $this->insertAdminToDatabase($faker, $now);
    }

    /**
     * @param Faker $faker
     * @param Carbon $now
     * @return void
     * @throws Exception
     */
    private function insertAdminToDatabase(Faker $faker, Carbon $now): void
    {
        /**
         * @var User $user
         */
        $user = User::query()->create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => 'admin@example.com',
            'password' => '$2y$10$bk2o.4kOqcFMC6gqAAP8H.yURbc20ZsstVy2ZnH7d9CfWKRKejnLi',
            'image' => null,
            'date_of_birth' => generateRandomDate(Carbon::create('1965', '5', '5'), Carbon::create('2000', '5', '5')),
            'first_work_date' => generateRandomDate(Carbon::create('1990', '5', '5'), Carbon::now()),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $role = Role::whereName(Role::MANAGER_ROLE)->first();

        if ($role) {
            $user->roles()->sync([$role->getKey()]);
        }

        $user->profile()->create([
            'job_title' => $faker->jobTitle,
            'social_links' => [
                [
                    'name' => 'github',
                    'profile_name' => $faker->name,
                    'link' => 'https://github.com/' . $faker->name,
                ],
                [
                    'name' => 'slack',
                    'profile_name' => 'https://' . $faker->name . 'slack.com',
                    'link' => 'https://github.com/' . $faker->name,
                ],
                [
                    'name' => 'linkedin',
                    'profile_name' => $faker->name,
                    'link' => 'https://www.linkedin.com/in/' . $faker->name,
                ],
            ],
            'short_description' => $faker->text(1500),
        ]);
    }
}
