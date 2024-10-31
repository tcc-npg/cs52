<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBalanceToMsModuleStudents extends Migration
{
    
    public function up()
    {
        $this->forge->addColumn('ms_module_students', [
            'balance' => [
                'type' => 'float',
                'constraint' => '10,2',
                'unsigned' => true,
                'null' => false,
                'default' => 0.00,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('ms_module_students', 'balance');
    }
}
