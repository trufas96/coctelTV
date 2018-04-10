<?php
namespace Fuel\Migrations;


class Recetas
{

    function up()
    {
        \DBUtil::create_table('Recetas', 
            array(
                'id' => array('type' => 'int', 'constraint' => 100,'auto_increment' => true),
                'name' => array('type' => 'varchar', 'constraint' => 500),
                'profilePReceta' => array('type' => 'varchar', 'constraint' => 500),
                'ingrediente1' => array('type' => 'varchar', 'constraint' => 300,NULL),
                'ingrediente2' => array('type' => 'varchar', 'constraint' => 300,NULL),
                'ingrediente3' => array('type' => 'varchar', 'constraint' => 300,NULL),
                'ingrediente4' => array('type' => 'varchar', 'constraint' => 300,NULL),
                'ingrediente5' => array('type' => 'varchar', 'constraint' => 300,NULL),
                'ingrediente6' => array('type' => 'varchar', 'constraint' => 300,NULL),
                'ingrediente7' => array('type' => 'varchar', 'constraint' => 300,NULL),
                'ingrediente8' => array('type' => 'varchar', 'constraint' => 300,NULL),
                'ingrediente9' => array('type' => 'varchar', 'constraint' => 300,NULL),
                'ingrediente10' => array('type' => 'varchar', 'constraint' => 300,NULL),
                'id_user' => array('type'=> 'int', 'constraint' => 100)

        ), array('id'), false, 'InnoDB', 'utf8_unicode_ci',
    array(
        array(
            'constraint' => 'ForeingKeyRecetasToUser',
            'key' => 'id_user',
            'reference' => array(
                'table' => 'Users',
                'column' => 'id',
            ),
            'on_update' => 'CASCADE',
            'on_delete' => 'RESTRICT'
            ))
        );
           
    }

    function down()
    {
       \DBUtil::drop_table('Recetas');
    }
}


?>