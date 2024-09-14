<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableIsBooks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'book_name' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => false,
            ],
            'author' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('is_books');
    }

    public function down()
    {
        $this->forge->dropTable('is_books');
    }
}
