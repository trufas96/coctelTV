<?php 

class Model_RecetasLocal extends Orm\Model
{
    protected static $_table_name = 'RecetaLocals';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id',
        'title' => array(
            'data_type' => 'varchar'   
        ),
        'url' => array(
            'data_type' => 'varchar'   
        )
    );
    protected static $_many_many = array(
        'recetasLocal' => array(
            'key_from' => 'id',
            'key_through_from' => 'id_local', 
            'table_through' => 'recetasLocal', 
            'key_through_to' => 'id_song', 
            'model_to' => 'Model_RecetasLocal',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
}