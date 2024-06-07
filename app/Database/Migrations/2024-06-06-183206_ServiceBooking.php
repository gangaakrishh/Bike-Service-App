<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ServiceBooking extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => '20',
            ],
            'service_id' => [
                'type' => 'INT',
                'constraint' => '10',
            ],
            'status_id' => [
                'type' => 'INT',
                'constraint' => '10',
            ],
            'date' => [
                'type' => 'VARCHAR',
                'constraint' => '30'
            ],
            'comment' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
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
        $this->forge->createTable('service_booking');
    }

    public function down()
    {
        $this->forge->dropTable('service_booking');
    }
}