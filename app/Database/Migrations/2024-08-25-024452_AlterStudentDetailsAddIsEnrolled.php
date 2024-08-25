<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterStudentDetailsAddIsEnrolled extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('student_details', [
            'is_enrolled' => [
                'type' => 'tinyint',
                'constraint' => 1,
                'default' => 0,
            ]
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('student_details', 'is_enrolled');
    }
}
