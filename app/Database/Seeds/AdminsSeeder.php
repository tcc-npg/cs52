<?php

namespace App\Database\Seeds;

use App\Entities\UserEntity;
use App\Models\UserDetailsModel;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Entities\UserIdentity;
use CodeIgniter\Shield\Models\UserIdentityModel;
use Faker\Factory;
use ReflectionException;

class AdminsSeeder extends Seeder
{
    /**
     * @throws ReflectionException
     */
    public function run(): void
    {
        $faker = Factory::create();

        $userModel = model(UserModel::class);
        $userDetailsModel = model(UserDetailsModel::class);
        $userIdentityModel = model(UserIdentityModel::class);

        $userModel->insert([
            'username' => $faker->unique()->userName(),
            'active' => 1,
            'user_type' => PROFESSOR
        ]);

        $id = $userModel->getInsertID();

        $adminUser = $this->db->query("select * from users where id = $id")->getRowArray();

        $user = (new UserEntity())->fill($adminUser);

        $user->addGroup('admin');

        $userDetailsModel->insert([
            'user_id' => $id,
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'middle_name' => $faker->lastName(),
            'gender' => $faker->randomElement(['M', 'F']),
            'phone_number' => $faker->phoneNumber(),
            'address' => $faker->address(),
        ]);

        $userIdentity = (new UserIdentity())->fill([
            'user_id' => $id,
            'type' => 'email_password',
            'secret' => $faker->unique()->email(),
            'secret2' => (service('passwords'))->hash('admin123')
        ]);

        $userIdentityModel->save($userIdentity);
    }
}
