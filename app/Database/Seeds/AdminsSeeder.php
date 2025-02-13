<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use ReflectionException;

class AdminsSeeder extends Seeder
{
    /**
     * @throws ReflectionException
     */
    public function run(): void
    {
        UserFaker::create(ADMIN, 'admin123', 1);
    }
}
