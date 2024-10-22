<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveColumnsFromMsModuleStudents extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('ms_module_students', ['payment', 'payment_date']);
    }

    public function down()
    {
        //
    }
}
