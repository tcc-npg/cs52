<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateNewTableOtherPayablePayees extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'payable_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'payment' => [
                'type' => 'float',
                'constraint' => '10,2',
                'unsigned' => true,
                'null' => false,
                'default' => 0.00,
            ],
            'status' => [
                'type' => 'enum',
                'constraint' => ['p', 'c'],
                'null' => true,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null,
            ]
        ]);

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE');
        $this->forge->addForeignKey('payable_id', 'ms_other_payables', 'payable_id', 'CASCADE');

        $this->forge->addPrimaryKey(['payable_id', 'user_id']);
        $this->forge->createTable('ms_payable_payee');
    }

    public function down()
    {
        //
    }
}
