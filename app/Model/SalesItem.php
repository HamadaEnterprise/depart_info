<?php

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class SalesItem extends AppModel {

	public $useTable = 'sales_item';
	var $name = 'SalesItem';
	var $primaryKey = 'month';

	var $hasOne = array('SalesItemYearOnYear' =>
                    array('className' => 'SalesItemYearOnYear',
                          'conditions' => '',
                          'order' => '',
                          'dependent' => true,
                          'foreignKey' => 'month'
                    )
                  );
    
}
