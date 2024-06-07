<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Services extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 50,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'unique' => true,
                'constraint' => '50',
            ],
            'description' => [
                'type' => 'VARCHAR',
                'unique' => true,
                'constraint' => '200',
            ],
            'price' => [
                'type' => 'INT',
                'unique' => true,
                'constraint' => '20',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('services');
    }

    public function down()
    {
        $this->forge->dropTable('services');
    }
}