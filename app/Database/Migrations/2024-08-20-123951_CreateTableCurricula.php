<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableCurricula extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'auto_increment' => true,
                'null' => false,
                'unsigned' => true
            ],
            'description' => [
                'type' => 'varchar',
                'constraint' => '100',
                'null' => false
            ],
            'date_created' => [
                'type' => 'datetime',
                'null' => false,
                'default' => new RawSql('current_timestamp')
            ],
            'date_updated' => [
                'type' => 'datetime',
                'null' => true
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('curricula');
    }

    public function down(): void
    {
        $this->forge->dropTable('curricula');
    }
}
