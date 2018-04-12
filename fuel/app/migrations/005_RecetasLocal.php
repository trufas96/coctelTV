<?php
namespace Fuel\Migrations;


class RecetasLocal
{

    function up()
    {
        \DBUtil::create_table('RecetasLocal', 
            array(
                'id' => array('type' => 'int', 'constraint' => 100,'auto_increment' => true),
                'name' => array('type' => 'varchar', 'constraint' => 500),
                'profilePReceta' => array('type' => 'varchar', 'constraint' => 500),

            ), array('id'));
           
    }

    function down()
    {
       \DBUtil::drop_table('RecetasLocal');
    }
}


?>