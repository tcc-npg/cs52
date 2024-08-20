<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterStudentDetailsAddKey extends Migration
{
    public function up(): void
    {
        $this->db->query('alter table student_details add key student_details_year_level_key (year_level)');
    }

    public function down(): void
    {
        $this->forge->dropKey('student_details', 'student_details_year_level_key');
    }
}
