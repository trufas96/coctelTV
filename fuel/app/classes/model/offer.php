<?php
class Model_Offers extends Orm\Model 
{
    protected static $_table_name = 'offers';
    protected static $_primary_key = array('id');
    protected static $_properties = array
    ('id' => array('data_type'=>'int'), // both validation & typing observers will ignore the PK
     'nameOffer' => array(
            'data_type' => 'varchar',
            'validation' => array('max_length' => array(500))
        ),
     'percentage' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(300))   
         ),
     'nameLocal' => array(
                'data_type' => 'varchar',
                'validation' => array('max_length' => array(100))   
         ),
     'normalPrize' => array(
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