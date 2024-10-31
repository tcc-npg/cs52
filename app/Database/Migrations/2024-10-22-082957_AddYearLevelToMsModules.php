<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddYearLevelToMsModules extends Migration
{
    public function up()
    {
        $this->forge->addColumn('ms_modules', [
            'year_level' => [
                'type' => 'enum',
                'constraint' => ['1st', '2nd', '3rd', '4th', 'all'],
                'null' => false,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('ms_modules', 'year_level');
    }
}
