<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateForeignKeyConstraints extends Migration
{
    public function up()
    {
    
        $this->forge->dropForeignKey('ms_payable_payee', 'ms_payable_payee_payable_id_foreign');

       
        $this->forge->addForeignKey('payable_id', 'ms_other_payables', 'payable_id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        
        $this->forge->dropForeignKey('ms_payable_payee', 'ms_payable_payee_payable_id_foreign');

     
    }
}
