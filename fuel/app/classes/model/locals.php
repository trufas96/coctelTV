<?php
class Model_Locals extends Orm\Model 
{
    protected static $_table_name = 'Locals';
    protected static $_primary_key = array('id');
    protected static $_properties = array
    ('id' => array('data_type'=>'int'), // both validation & typing observers will ignore the PK
     'name' => array(
            'data_type' => 'varchar',
            'validation' => array('max_length' => array(500))
        ),
     'direction' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(300))   
         ),
     'CP' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'localTelephone' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'daysL' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'holidays' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'morning' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'evening' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'profilePLocal' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'city' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'city2' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'x' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'y' => array(
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