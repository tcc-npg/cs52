<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveColumnsFromMsPayablePayees extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('ms_payable_payee', ['payment', 'payment_date']);

    }

    public function down()
    {
        //
    }
}
