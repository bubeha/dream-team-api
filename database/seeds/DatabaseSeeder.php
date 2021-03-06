<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder // @codingStandardsIgnoreLine
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(RolesTableSeeder::class);
        $this->call(ManagerTableSeeder::class);
        $this->call(EmployeeTableSeeder::class);
        $this->call(GenerateUsersTableSeeder::class);
        $this->call(ReviewsSeeder::class);
        $this->call(ProfileRatingSeeder::class);
    }
}
