<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableStudentDetails extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'student_number' => [
                'type' => 'varchar',
                'constraint' => 10,
                'null' => false,
            ],
            'year_level' => [
                'type' => 'tinyint',
                'constraint' => 1,
                'null' => false,
                'default' => 1,
            ],
            'program_code' => [
                'type' => 'varchar',
                'constraint' => 10,
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
        $this->db->disableForeignKeyChecks();
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('program_code', 'programs', 'code');
        $this->forge->createTable('student_details');
        $this->db->enableForeignKeyChecks();
    }

    public function down(): void
    {
        $this->forge->dropTable('student_details');
    }
}
