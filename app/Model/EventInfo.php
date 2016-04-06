<?php

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class EventInfo extends AppModel {

	public $useTable = 'event_info';
	var $name = 'EventInfo';
    var $belongsTo = array('Depart' =>
                        array('className'  => 'Depart',
                              'conditions' => '',
                              'foreignKey' => 'depart_id'
                        )
                      );
}
