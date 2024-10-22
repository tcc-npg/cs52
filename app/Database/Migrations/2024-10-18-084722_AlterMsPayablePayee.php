<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMsPayablePayee extends Migration
{
    public function up()
    {
        $fields = [
            'payment_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ];

        $this->forge->addColumn('ms_payable_payee', $fields);
    }

    public function down()
    {
        // To rollback the migration, we drop the column
        $this->forge->dropColumn('ms_payable_payee', 'payment_date');
    }
}

