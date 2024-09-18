<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableSchoolYears extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => false,
            ],
            'start_date' => [
                'type' => 'datetime',
                'null' => false,
            ],
            'end_date' => [
                'type' => 'datetime',
                'null' => false,
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
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('school_years');
    }

    public function down(): void
    {
        $this->forge->createTable('school_years');
    }
}
