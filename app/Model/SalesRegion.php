<?php

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class SalesRegion extends AppModel {

	public $useTable = 'sales_region';
	var $name = 'SalesRegion';
	var $primaryKey = 'month';
	/*var $belongsTo = array('SalesRegionYearOnYear' =>
                        array('className'  => 'SalesRegionYearOnYear',
                              'foreignKey' => 'month'
                        )
                      );*/
	var $hasOne = array('SalesRegionYearOnYear' =>
                    array('className' => 'SalesRegionYearOnYear',
                          'conditions' => '',
                          'order' => '',
                          'dependent' => true,
                          'foreignKey' => 'month'
                    )
                  );
	
}
