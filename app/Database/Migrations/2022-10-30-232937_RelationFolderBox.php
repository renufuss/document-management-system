<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RelationFolderBox extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'folder_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'box_id'       => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addForeignKey('folder_id', 'app_folder', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('box_id', 'app_box', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('relation_folder_box', true);
    }

    public function down()
    {
        $this->forge->dropTable('relation_folder_box');
    }
}
