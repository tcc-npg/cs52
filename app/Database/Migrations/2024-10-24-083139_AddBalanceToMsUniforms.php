<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBalanceToMsUniforms extends Migration
{
    public function up()
    {
        $this->forge->addColumn('ms_uniforms', [
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
        $this->forge->dropColumn('ms_modules', 'amount');
    }
}
