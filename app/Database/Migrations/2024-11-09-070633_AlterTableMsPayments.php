<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableMsPayments extends Migration
{
    public function up()
    {
        $this->forge->addColumn('ms_payments', [
            'is_deleted' => [
                'type' => 'tinyint',
                'constraint' => 1,
                'null' => false,
                'default' => 0
            ],
        ]);
    
    }

    public function down()
    {
        //
    }
}
