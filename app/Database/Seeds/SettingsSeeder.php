<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('settings')->insert([
            'class' => 'SY',
            'key' => 'current_sem',
            'value' => '1',
            'type' => 'int',
            'context' => 'Current Semester',
            'created_at' => new RawSql('current_timestamp'),
        ]);
    }
}
