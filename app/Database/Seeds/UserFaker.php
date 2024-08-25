<?php

namespace App\Database\Seeds;

use App\Entities\UserEntity;
use App\Models\StudentDetailsModel;
use App\Models\UserDetailsModel;
use App\Models\UserModel;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Shield\Entities\UserIdentity;
use CodeIgniter\Shield\Models\UserIdentityModel;
use Config\Database;
use Faker\Factory;
use ReflectionException;

class UserFaker
{
    private static ?BaseConnection $db = null;

    protected static array $groups = [
        ADMIN => 'admin',
        PROFESSOR => 'professor',
        STUDENT => 'student',
    ];

    /**
     * @throws ReflectionException
     */
    public static function create(string $role, string $commonPassword, int $times = 10): void
    {
        self::initDb();


        $faker = Factory::create();

        $userModel = model(UserModel::class);
        $userDetailsModel = model(UserDetailsModel::class);
        $userIdentityModel = model(UserIdentityModel::class);
        $studentDetailsModel = model(StudentDetailsModel::class);

        for ($i = 1; $i <= $times; $i++) {
            $userModel->insert([
                'username' => $faker->unique()->userName(),
                'active' => 1,
                'user_type' => $role
            ]);

            $id = $userModel->getInsertID();

            $createdUser = self::getCreatedUserData($id);
            $user = (new UserEntity())->fill($createdUser);
            $user->addGroup(self::$groups[$role]);
            $userDetailsModel->insert(self::generateUserDetails($id, $faker));

            $userIdentity = (new UserIdentity())->fill(self::generateUserIdentity($id, $commonPassword, $faker));
            $userIdentityModel->save($userIdentity);

            if ($role === STUDENT) {
                $studentDetailsModel->save(self::generateStudentDetails($id, $faker));
            }
        }
    }

    private static function getCreatedUserData(int $id): array
    {
        return self::$db->query("select * from users where id = $id")->getRowArray();
    }

    private static function generateUserDetails(int $id, &$faker): array
    {
        return [
            'user_id' => $id,
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'middle_name' => $faker->lastName(),
            'gender' => $faker->randomElement(['M', 'F']),
            'phone_number' => $faker->phoneNumber(),
            'address' => $faker->address(),
        ];
    }

    private static function generateStudentDetails(int $id, &$faker): array
    {
        return [
            'user_id' => $id,
            'student_number' => substr($faker->unique()->uuid(), 0, 10),
            'is_irreg' => $faker->randomElement([1, 0]),
            'is_enrolled' => 0,
            'program_code' => 'bscs',
            'year_level' => $faker->randomElement([1, 2, 3, 4]),
        ];
    }

    private static function generateUserIdentity(int $id, string $password, &$faker): array
    {
        return [
            'user_id' => $id,
            'type' => 'email_password',
            'secret' => $faker->unique()->email(),
            'secret2' => (service('passwords'))->hash($password)
        ];
    }

    private static function initDb(): void
    {
        if (self::$db === null) {
            self::$db = Database::connect();
        }
    }
}