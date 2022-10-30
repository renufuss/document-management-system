<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Document extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'number'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'file'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'size'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'status'       => [
                'type'           => 'TINYINT',
                'constraint'     => '1'
            ],
            'room_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
                'null'        => true,
            ],
            'shelf_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
                'null'        => true,
            ],
            'box_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
                'null'        => true,
            ],
            'folder_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
                'null'        => true,
            ],
            'order_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
                'null'        => true,
            ],
            'created_at'      => [
                'type'           => 'DATETIME',
                'null'        => true,
            ],
            'updated_at'      => [
                'type'           => 'DATETIME',
                'null'        => true,
            ],
            'deleted_at'      => [
                'type'           => 'DATETIME',
                'null'        => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('room_id', 'app_room', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('shelf_id', 'app_shelf', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('box_id', 'app_box', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('folder_id', 'app_folder', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('order_id', 'app_order', 'id', 'SET NULL', 'SET NULL');

        $this->forge->createTable('app_document', true);
    }

    //-------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('app_document');
    }
}
