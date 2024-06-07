<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ServiceStatus extends Migration
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
        $this->forge->createTable('service_status');
    }

    public function down()
    {
        $this->forge->dropTable('service_status');
    }
}