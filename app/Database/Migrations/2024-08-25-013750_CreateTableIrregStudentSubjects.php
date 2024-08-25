<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableIrregStudentSubjects extends Migration
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
            'subject_id' => [
                'type' => 'int',
                'unsigned' => true,
                'null' => false,
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
        $this->forge->addForeignKey('subject_id', 'subjects', 'id', '', 'cascade');
        $this->forge->createTable('irreg_student_subjects');
        $this->db->query('alter table irreg_student_subjects add constraint primary key (user_id, subject_id)');
    }

    public function down(): void
    {
        $this->forge->dropTable('irreg_student_subjects');
    }
}
