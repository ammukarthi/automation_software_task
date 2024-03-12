<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class IlanceCategories extends Migration
{
    public function up()
    {
        $fields = array(
            'category_id' => array(
                    'type' => 'INT',
                    'constraint' => 10,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
            ),
            'category_name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'unique' => TRUE,
            ),
            'category_description' => array(
                    'type' => 'TEXT',
                    'null' => TRUE,
            ),
        );

        $this->forge->addField($fields);
        $this->forge->addKey('category_id',true);
        $this->forge->createTable('ilance_categories');
    }

    public function down()
    {
        $this->forge->dropTable('ilance_categories');
    }
}
