<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	//Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/', array('controller' => 'homes', 'action' => 'index'));
	//Router::connect('/getSogoYokohama', array('controller' => 'homes', 'action' => 'getSogoYokohamaInfo'));
	Router::connect('/getIsetan', array('controller' => 'homes', 'action' => 'startGetIsetanData'));
	Router::connect('/getMitsukoshi', array('controller' => 'homes', 'action' => 'startGetMitsukoshiData'));
	Router::connect('/getTakashimaya', array('controller' => 'homes', 'action' => 'startGetTakashimayaData'));
	Router::connect('/getJfront', array('controller' => 'homes', 'action' => 'startGetJfrontData'));
	Router::connect('/getTokyu', array('controller' => 'homes', 'action' => 'startGetTokyu'));
	Router::connect('/getOdakyu', array('controller' => 'homes', 'action' => 'startGetOdakyu'));
	Router::connect('/getKeikyu', array('controller' => 'homes', 'action' => 'startGetkeikyu'));
	Router::connect('/getMatsuya', array('controller' => 'homes', 'action' => 'startGetMatsuya'));
	Router::connect('/getTobu', array('controller' => 'homes', 'action' => 'startGetTobu'));
	Router::connect('/getSeibu', array('controller' => 'homes', 'action' => 'startGetSeibu'));
	Router::connect('/categorize', array('controller' => 'homes', 'action' => 'categorize'));
	Router::connect('/getAllEvents', array('controller' => 'homes', 'action' => 'getAllEvents'));
	Router::connect('/getEventInfoTimeStamp', array('controller' => 'homes', 'action' => 'getEventInfoTimeStamp'));
	Router::connect('/getSogo', array('controller' => 'homes', 'action' => 'startGetSogo'));
	Router::connect('/getKeio', array('controller' => 'homes', 'action' => 'startGetKeio'));
	Router::connect('/getKeioSakuragaoka', array('controller' => 'homes', 'action' => 'startGetKeioSakuragaoka'));
	Router::connect('/departDetail', array('controller' => 'Departs', 'action' => 'departDetail'));
	//Router::connect('/admin/entryEvent', array('controller' => 'Admin', 'action' => 'entryEvent'));
	Router::connect('/IOSController', array('controller' => 'IOS', 'action' => 'index'));
	Router::connect('/IOSController/todaysEvents', array('controller' => 'IOS', 'action' => 'todaysEvents'));
	Router::connect('/IOSController/xmlTest', array('controller' => 'IOS', 'action' => 'xmlTest'));
	Router::connect('/IOSController/googleNews', array('controller' => 'IOS', 'action' => 'getGoogleNews'));
	Router::connect('/IOSController/calendar', array('controller' => 'IOS', 'action' => 'calendar'));

/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
