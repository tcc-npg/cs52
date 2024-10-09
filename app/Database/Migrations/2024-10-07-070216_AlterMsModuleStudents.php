<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterStudentsTable extends Migration
{
    public function up()
    {
        // Rename 'balance' column to 'payment'
        $this->forge->modifyColumn('ms_module_students', [
            'balance' => [
                'name' => 'payment',  // You missed the renaming part
                'type' => 'FLOAT',
                'constraint' => '10,2',
                'unsigned' => true,
                'null' => false,
                'default' => 0.00,
            ]
        ]);
    }

    public function down()
    {
        // Rename 'payment' column back to 'balance'
        $this->forge->modifyColumn('ms_module_students', [
            'payment' => [
                'name' => 'balance',  // Revert the renaming
                'type' => 'FLOAT',
                'constraint' => '10,2',
                'unsigned' => true,
                'null' => false,
                'default' => 0.00,
            ]
        ]);
    }
}