<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RelationShelfRoom extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'shelf_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'room_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addForeignKey('shelf_id', 'app_shelf', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('room_id', 'app_room', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('relation_shelf_room', true);
    }

    public function down()
    {
        $this->forge->dropTable('relation_shelf_room');
    }
}
