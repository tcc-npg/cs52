<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterSettingsAddKey extends Migration
{
    public function up(): void
    {
        $this->db->query(
            'alter table settings add unique key settings_key_uq (`key`)'
        );
    }

    public function down(): void
    {
        $this->forge->dropKey('settings', 'settings_key_uq');
    }
}
