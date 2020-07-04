<?php

declare(strict_types=1);

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class UsersTableSeeder
 */
class EmployeeTableSeeder extends Seeder // @codingStandardsIgnoreLine
{
    /**
     * Run seeder
     * @throws Exception
     */
    public function run(): void
    {
        $countManagers = User::query()->where('email', '=', 'employee@example.com')->count();

        if ($countManagers > 0) {
            return;
        }

        $this->insertAdminToDatabase();
    }

    /**
     * @return void
     */
    private function insertAdminToDatabase(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'email' => 'employee@example.com',
        ]);

        $role = Role::whereName(Role::EMPLOYER_ROLE)->first();

        if ($role) {
            $user->roles()->sync([$role->getKey()]);
        }

        factory(Profile::class)->create([
            'user_id' => $user->getKey(),
        ]);
    }
}
