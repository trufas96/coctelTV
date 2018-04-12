<?php
namespace Fuel\Migrations;


class Locals
{

    function up()
    {
        \DBUtil::create_table('Locals', 
            array(
                'id' => array('type' => 'int', 'constraint' => 100,'auto_increment' => true),
                'name' => array('type' => 'varchar', 'constraint' => 500),
                'direction' => array('type' => 'varchar', 'constraint' => 300),
                'CP' => array('type' => 'varchar', 'constraint' => 300),
                'localTelephone' => array('type' => 'varchar', 'constraint' => 300),
                'daysL' => array('type' => 'varchar', 'constraint' => 300),
                'holidays' => array('type' => 'varchar', 'constraint' => 300),
                'morning' => array('type' => 'varchar', 'constraint' => 300),
                'evening' => array('type' => 'varchar', 'constraint' => 300),
                'profilePLocal' => array('type' => 'varchar', 'constraint' => 500),
                'city' => array('type' => 'varchar', 'constraint' => 300),
                'city2' => array('type' => 'varchar', 'constraint' => 300, NULL),
                'x' => array('type' => 'varchar', 'constraint' => 100, NULL),
                'y' => array('type' => 'varchar', 'constraint' => 100, NULL),
                'id_user' => array('type'=> 'int', 'constraint' => 100)

        ), array('id'), false, 'InnoDB', 'utf8_unicode_ci',
    array(
        array(
            'constraint' => 'ForeingKeyLocalsToUser',
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
       \DBUtil::drop_table('Locals');
    }
}


?>