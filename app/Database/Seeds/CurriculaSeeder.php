<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CurriculaSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('curricula')->insert([
            'description' => 'S.Y. 2023-2024 curriculum'
        ]);
    }
}
