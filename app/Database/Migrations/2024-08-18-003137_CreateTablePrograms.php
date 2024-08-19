<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTablePrograms extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'code' => [
                'type' => 'varchar',
                'constraint' => 10,
                'null' => false
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 100,
                'null' => false
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null,
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null
            ],
            'deleted_by' => [
                'type' => 'int',
                'null' => true,
                'default' => null,
                'unsigned' => true,
            ]
        ]);
        $this->db->disableForeignKeyChecks();
        $this->forge->addPrimaryKey('code');
        $this->forge->addForeignKey('deleted_by', 'users', 'id');
        $this->forge->createTable('programs');
        $this->db->enableForeignKeyChecks();
    }

    public function down(): void
    {
        $this->forge->dropTable('programs');
    }
}
