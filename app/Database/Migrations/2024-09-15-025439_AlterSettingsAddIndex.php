<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterSettingsAddIndex extends Migration
{
    public function up(): void
    {
        $this->db->query('alter table settings add key settings_class_key (class)');
    }

    public function down(): void
    {
        $this->forge->dropKey('settings', 'settings_class_key');
    }
}
