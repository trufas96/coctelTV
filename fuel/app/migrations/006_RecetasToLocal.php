<?php
namespace Fuel\Migrations;


class RecetasToLocal
{

    function up()
    {   
        try
        {
            \DBUtil::create_table(
                'RecetasToLocal',
                array(
                    'id_local' => array('constraint' => 11, 'type' => 'int'),
                    'id_receta' => array('constraint' => 11, 'type' => 'int'),
                ),
                array('id_local', 'id_receta'), false, 'InnoDB', 'utf8_general_ci',
                array(
                    array(
                        'constraint' => 'foreingKeyLocalToRecetaLocal',
                        'key' => 'id_local',
                        'reference' => array(
                            'table' => 'Locals',
                            'column' => 'id',
                        ),
                        'on_update' => 'CASCADE',
                        'on_delete' => 'RESTRICT'
                    ),
                    array(
                        'constraint' => 'foreingKeyRecetaLocalToLocal',
                        'key' => 'id_receta',
                        'reference' => array(
                            'table' => 'RecetasLocal',
                            'column' => 'id',
                        ),
                        'on_update' => 'CASCADE',
                        'on_delete' => 'RESTRICT'
                    ),
                )
            );
        }
        catch(\Database_Exception $e)
        {
           echo 'Lista ya creada'; 
        }
    }

    function down()
    {
       \DBUtil::drop_table('RecetasToLocal');
    }

}