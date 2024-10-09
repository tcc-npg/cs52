<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMsUniforms extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('ms_uniforms', [
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
        $this->forge->modifyColumn('ms_uniforms', [
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
