<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SchoolYearSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('school_years')->insert([
            'name' => '2024-2025',
            'start_date' => date_format(date_create('2024-08-10'), 'Y-m-d'),
            'end_date' => date_format(date_create('2025-06-10'), 'Y-m-d'),
        ]);
    }
}
