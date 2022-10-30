<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RelationOrderFolder extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'folder_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addForeignKey('order_id', 'app_order', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('folder_id', 'app_folder', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('relation_order_folder', true);
    }

    public function down()
    {
        $this->forge->dropTable('relation_order_folder');
    }
}
