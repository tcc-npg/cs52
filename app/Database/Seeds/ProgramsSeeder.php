<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProgramsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'code' => 'bscs',
            'name'    => 'Bachelor of Science in Computer Science',
        ];
        $this->db->table('programs')->insert($data);
    }
}
