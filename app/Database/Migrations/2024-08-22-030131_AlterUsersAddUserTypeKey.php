<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersAddUserTypeKey extends Migration
{
    public function up(): void
    {
        $this->db->query('alter table users add key user_type_idx (user_type)');
    }

    public function down(): void
    {
        $this->forge->dropKey('users', 'user_type_idx');
    }
}
