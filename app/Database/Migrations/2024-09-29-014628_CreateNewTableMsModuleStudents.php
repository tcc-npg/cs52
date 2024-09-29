<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;
class CreateNewTableMsModuleStudents extends Migration
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
            'module_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'balance' => [
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

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE'); // Foreign key for user_id
        $this->forge->addForeignKey('module_id', 'ms_modules', 'module_id', 'CASCADE', 'CASCADE');


        $this->forge->addPrimaryKey(['user_id', 'module_id']);
        $this->forge->createTable('ms_module_students');
    }

    public function down()
    {
        //
    }
}
