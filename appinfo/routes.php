<?php
/**
 * ownCloud - exifview
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author shi <shi@example.com>
 * @copyright shi 2015
 */

/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\ExifView\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return array(
	'routes' => array(
		array(
			'name' => 'page#index',
			'url' => '/p', 'verb' => 'GET'
		),
		array(
			'name' => 'json#index',
			'url' => '/show/',
			'verb' => 'GET' 
		),
		array(
			'name' => 'json#show',
			'url' => '/show/{path}',
			'verb' => 'GET',
			'requirements' => array('path' => '.+')
		),
		array(
			'name' => 'json#showgps',
			'url' => '/showgps/{path}',
			'verb' => 'GET',
			'requirements' => array('path' => '.+')
		),
		array(
			'name' => 'json#time',
			'url' => '/time/{path}',
			'verb' => 'GET',
			'requirements' => array('path' => '.+')
		),
		array(
			'name' => 'json#test',
			'url' => '/test/{foo}',
			'verb' => 'GET',
			'requirements' => array('foo' => '.+')
		),
	)
);
