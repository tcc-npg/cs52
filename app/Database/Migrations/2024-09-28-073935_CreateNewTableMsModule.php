<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateNewTableMsModule extends Migration
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
            'code' => [
               'type' => 'varchar',
                'constraint' => '10',
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
        // $this->forge->addForeignKey('prof_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('code', 'subjects', 'code', '', 'CASCADE');
        $this->forge->addPrimaryKey('module_id');
        $this->forge->createTable('ms_modules');
        
    }

    public function down()
    {
        $this->forge->dropTable('ms_modules');
    }
}
