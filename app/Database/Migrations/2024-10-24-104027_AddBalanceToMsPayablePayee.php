<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBalanceToMsPayablePayee extends Migration
{
    public function up()
    {
        $this->forge->addColumn('ms_payable_payee', [
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
        $this->forge->dropColumn('ms_payable_payee', 'balance');
    }
}
