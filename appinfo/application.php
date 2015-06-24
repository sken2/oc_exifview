<?php

namespace OCA\ExifView\AppInfo;

use \OCP\AppFramework\App;
//use \OCP\Files\Folder;

use \OCA\ExifView\Controller\PageController;
use \OCA\ExifView\Controller\JsonController;

use \OCA\ExifView\Storage\PhotoStorage;
use \OCA\ExifView\Db\PhotoDBO;


class Applicaton extends App {

	public function __construct(array $urlParams=array()){

		parent::__construct('exifview', $urlParams);

		$container = $this->getContainer();

		$container->registerService('PhotoStorage', function ($c){
			return new PhotoStorage(
				$c->query('AppName'),
				$c->query('UserId'),
				$c->query('UserStorage'),
				$c->query('AppStorage'),
				$c->query('PhotoDBO')
			);
		});

		$container->registerService('AppStorage', function ($c) {
			return $c->query('ServerContainer')->getRootFolder();
		});

		$container->registerService('PhotoDBO', function ($c){
			return new PhotoDBO(
				$c->query('AppName'),
				$c->query('UserId'),
				$c->query('ServerContainer')->getDB()
			);
		});

		$container->registerService('UserStorage', function ($c){
			return $c->query('ServerContainer')->getUserFolder();
		});

		$container->registerService('JsonController', function($c){
			return new JsonController(
				$c->query('AppName'),
				$c->query('UserId'),
				$c->query('Request'),
				$c->query('PhotoStorage')
			);
		});
	}
}
