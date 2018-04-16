<?php
namespace Fuel\Migrations;


class Offers
{

    function up()
    {
        \DBUtil::create_table('offers', 
            array(
                'id' => array('type' => 'int', 'constraint' => 100,'auto_increment' => true),
                'nameOffer' => array('type' => 'varchar', 'constraint' => 500),
                'percentage' => array('type' => 'varchar', 'constraint' => 300),
                'nameLocal' => array('type' => 'varchar', 'constraint' => 300),
                'normalPrize' => array('type' => 'varchar', 'constraint' => 300),
                'x' => array('type' => 'varchar', 'constraint' => 100, NULL),
                'y' => array('type' => 'varchar', 'constraint' => 100, NULL),
                'id_user' => array('type'=> 'int', 'constraint' => 100)

        ), array('id'), false, 'InnoDB', 'utf8_unicode_ci',
    array(
        array(
            'constraint' => 'ForeingKeyOffersToUser',
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
       \DBUtil::drop_table('offers');
    }
}


?>