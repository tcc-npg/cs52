<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SettingsSeeder::class);
        $this->call(CurriculaSeeder::class);
        $this->call(ProgramsSeeder::class);
        $this->call(SubjectsSeeder::class);
        $this->call(AdminsSeeder::class);
    }
}
