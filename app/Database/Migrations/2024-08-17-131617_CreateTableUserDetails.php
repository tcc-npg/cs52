<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUserDetails extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'null' => false,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => '50',
            ],
            'middle_name' => [
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => '50',
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => '50',
            ],
            'gender' => [
                'type' => 'ENUM',
                'null' => false,
                'constraint' => ['M', 'F'],
            ],
            'phone_number' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => '11',
            ],
            'address' => [
                'type' => 'VARCHAR',
                'null' => false,
                'constraint' => '255',
            ],
            'user_type' => [
                'type' => 'ENUM',
                'null' => false,
                'constraint' => ['STU', 'PROF'],
            ]
        ]);
        $this->forge->addPrimaryKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('user_details');
    }

    public function down(): void
    {
        $this->forge->dropTable('user_details');
    }
}
