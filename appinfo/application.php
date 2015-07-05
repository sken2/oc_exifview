<?php

namespace OCA\ExifView\AppInfo;

use OCP\AppFramework\App;
use OCP\Files\Filesystem;

use OCP\Db\IDbconnection;

use OCA\ExifView\Controller\PageController;
use OCA\ExifView\Controller\JsonController;

use OCA\ExifView\Service\PhotoStorage;

class Applicaton extends App {

	public function __construct(array $urlParams=array()){

		parent::__construct('exifview', $urlParams);

		$container = $this->getContainer();

		$container->registerService('PhotoStorage', function ($c){
			return new PhotoStorage(
				$c->query('AppName'),
				$c->query('UserId'),
				$c->query('ServerContainer')->getUserFolder(),
				$c->query('ServerContainer')->getDBConnection()
			);
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
