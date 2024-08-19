<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableUserDetails extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'first_name' => [
                'type' => 'varchar',
                'null' => false,
                'constraint' => '50',
            ],
            'middle_name' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '50',
            ],
            'last_name' => [
                'type' => 'varchar',
                'null' => false,
                'constraint' => '50',
            ],
            'gender' => [
                'type' => 'enum',
                'null' => false,
                'constraint' => ['M', 'F'],
            ],
            'phone_number' => [
                'type' => 'varchar',
                'null' => false,
                'constraint' => '11',
            ],
            'address' => [
                'type' => 'varchar',
                'null' => false,
                'constraint' => '255',
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
        $this->db->disableForeignKeyChecks();
        $this->forge->addPrimaryKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('user_details');
        $this->db->enableForeignKeyChecks();
    }

    public function down(): void
    {
        $this->forge->dropTable('user_details', true);
    }
}
