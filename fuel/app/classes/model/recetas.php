<?php
class Model_Recetas extends Orm\Model 
{
    protected static $_table_name = 'Recetas';
    protected static $_primary_key = array('id');
    protected static $_properties = array
    ('id' => array('data_type'=>'int'), // both validation & typing observers will ignore the PK
     'name' => array(
            'data_type' => 'varchar',
            'validation' => array('max_length' => array(500))
        ),
     'profilePReceta' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(300))   
         ),
     'ingrediente1' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'ingrediente2' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'ingrediente3' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'ingrediente4' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'ingrediente5' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'ingrediente6' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'ingrediente7' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'ingrediente8' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'ingrediente9' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'ingrediente10' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'id_user' => array(
                'data_type' => 'int',
                'validation' => array('required', 'max_length' => array(100)))   
    );
    protected static $_belongs_to = array(
        'user' => array(
            'key_from' => 'id_user',
            'model_to' => 'Model_Users',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
}
?>