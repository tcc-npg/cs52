<?php

namespace App\Database\Migrations;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class CreateNewTableMsPayments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'payment_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
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
                'null' => true, // This can be nullable
            ],
            'module_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true, // This can be nullable
            ],
            'uniform_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true, // This can be nullable
            ],
            'payment_date' => [
                'type' => 'datetime',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'amount' => [
                'type' => 'float',
                'constraint' => '10,2',
                'unsigned' => true,
                'null' => false,
                'default' => 0.00,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null,
            ]
        ]);

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('payable_id', 'ms_other_payables', 'payable_id', 'CASCADE', 'CASCADE'); // Adjust the table name
        $this->forge->addForeignKey('module_id', 'ms_modules', 'module_id', 'CASCADE', 'CASCADE'); // Adjust the table name
        $this->forge->addForeignKey('uniform_id', 'ms_uniforms', 'id', 'CASCADE', 'CASCADE'); // Adjust the table name

        $this->forge->addPrimaryKey('payment_id');
        $this->forge->createTable('ms_payments');

    }

    public function down()
    {
        $this->forge->dropTable('ms_payments', true);
    }
}
