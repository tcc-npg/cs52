<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableStudentCurriculum extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'int',
                'unsigned' => true,
                'null' => false
            ],
            'curriculum_id' => [
                'type' => 'int',
                'unsigned' => true,
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
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'cascade');
        $this->forge->addForeignKey('curriculum_id', 'curricula', 'id', '', 'cascade');
        $this->forge->createTable('student_curriculum');
        $this->db->query('alter table student_curriculum add constraint primary key (user_id, curriculum_id)');
    }

    public function down(): void
    {
        $this->forge->dropTable('student_curriculum');
    }
}
