<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateNewTableUniforms extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'module_id' => [
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
            'shirt_size' => [
                'type' => 'enum',
                'constraint' => ['xs', 's', 'm', 'l', 'xl'],
                'null' => true,
            ],
            'pants_size' => [
                'type' => 'enum',
                'constraint' => ['xs', 's', 'm', 'l', 'xl'],
                'null' => true,
            ],
            'balance' => [
                'type' => 'float',
                'constraint' => '10,2', // No space between 10 and 2
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
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addPrimaryKey('module_id');
        $this->forge->createTable('ms_uniforms');
    }

    public function down()
    {
        $this->forge->dropTable('ms_uniforms');
    }
}
