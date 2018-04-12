<?php  
class Model_RecetasToLocal extends Orm\Model
{
	protected static $_table_name = 'RecetasToLocal';
	protected static $_primary_key = array('id_local', 'id_receta');
	protected static $_properties = array(
        'id_local'=> array('data_type' => 'int'), 
        'id_receta' => array('data_type' => 'int')
    );
	
}