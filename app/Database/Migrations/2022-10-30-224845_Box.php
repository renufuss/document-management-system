<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Box extends Migration
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

        $this->forge->createTable('app_box', true);
    }

    //-------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('app_box');
    }
}
