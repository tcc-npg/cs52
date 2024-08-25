<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use ReflectionException;

class StudentsSeeder extends Seeder
{
    /**
     * @throws ReflectionException
     */
    public function run(): void
    {
        UserFaker::create(STUDENT, 'pass123123');
    }
}
