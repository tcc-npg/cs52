<?php

namespace App\Database\Migrations;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class CreateNewTableOtherPayable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'payable_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
                'auto_increment' => true
            ],
            'payable_name' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null'  => false
            ],
            'amount' => [
                'type' => 'float',
                'constraint' => '10,2',
                'unsigned' => true,
                'null' => false,
                'default' => 0.00,
            ],
            'deadline' => [
                'type' => 'date',
                'null' => false
            ],
            'payees' => [
                'type' => 'enum',
                'constraint' => ['1st', '2nd', '3rd', '4th', 'all'],
                'null' => false,
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



        $this->forge->addPrimaryKey(['payable_id']);
        $this->forge->createTable('ms_other_payables');
    }

    public function down()
    {
        $this->forge->dropTable('ms_modules');
    }
}
