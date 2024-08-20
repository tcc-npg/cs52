<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableSubjects extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => true,
                'null' => false,
                'auto_increment' => true,
            ],
            'code' => [
                'type' => 'varchar',
                'constraint' => '10',
                'null' => false,
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => '100',
                'null' => false,
            ],
            'slug' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => false,
            ],
            'units' => [
                'type' => 'int',
                'null' => false,
            ],
            'description' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => true,
                'default' => null,
            ],
            'year_level' => [
                'type' => 'tinyint',
                'constraint' => 1,
                'null' => false,
            ],
            'semester' => [
                'type' => 'enum',
                'constraint' => ['1', '2', '3', 'summer'],
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => false,
                'default' => new RawSql('current_timestamp'),
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('code');
        $this->forge->createTable('subjects');
    }

    public function down(): void
    {
        $this->forge->dropTable('subjects');
    }
}
