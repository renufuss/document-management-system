<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RelationBoxShelf extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'box_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'shelf_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addForeignKey('box_id', 'app_box', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('shelf_id', 'app_shelf', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('relation_box_shelf', true);
    }

    public function down()
    {
        $this->forge->dropTable('relation_box_shelf');
    }
}
