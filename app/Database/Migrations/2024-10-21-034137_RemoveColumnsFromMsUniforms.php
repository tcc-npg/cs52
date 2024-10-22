<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveColumnsFromMsUniforms extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('ms_uniforms', ['payment', 'payment_date']);
    }

    public function down()
    {
        //
    }
}
