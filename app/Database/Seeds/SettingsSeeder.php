<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('settings')->insertBatch(
            [
                [
                    'class' => 'academic',
                    'key' => 'current_semester',
                    'value' => '1',
                    'type' => 'int',
                    'context' => 'Current Semester',
                    'created_at' => new RawSql('current_timestamp'),
                ],
                [
                    'class' => 'academic',
                    'key' => 'current_curriculum',
                    'value' => '1',
                    'type' => 'int',
                    'context' => 'Current Curriculum',
                    'created_at' => new RawSql('current_timestamp'),
                ],
                [
                    'class' => 'academic',
                    'key' => 'current_sy',
                    'value' => '1',
                    'type' => 'int',
                    'context' => 'Current school year',
                    'created_at' => new RawSql('current_timestamp'),
                ],
                [
                    'class' => 'accounts',
                    'key' => 'registration_enabled',
                    'value' => '1',
                    'type' => 'int',
                    'context' => 'Flag for checking if account registration is allowed',
                    'created_at' => new RawSql('current_timestamp'),
                ]
            ]
        );
    }
}
