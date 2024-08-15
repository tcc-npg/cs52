<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProfessors extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => '50',
            ],
            'middle_name' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => '50',
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => '50',
            ],
            'address' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => '255',
            ],
            'phone_number' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => '11',
            ],
            // for future just in case gamitin sa ibang depts
            'department_id' => [
                'type' => 'INT',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'DO NOTHING', 'CASCADE');
        $this->forge->createTable('professors');
    }

    public function down()
    {
        $this->forge->dropTable('professors');
    }
}
