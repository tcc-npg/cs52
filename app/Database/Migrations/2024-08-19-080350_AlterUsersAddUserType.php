<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersAddUserType extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('users', [
            'user_type' => [
                'type' => 'enum',
                'null' => false,
                'default' => 'STU',
                'constraint' => ['STU', 'PROF'],
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('users', 'user_type');
    }
}
