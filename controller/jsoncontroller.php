<?php
namespace OCA\ExifView\Controller;

use \Exception;

use \OCP\IRequest;
use \OCP\AppFramework\Http;
use \OCP\AppFramework\Http\DataResponse;
use \OCP\AppFramework\Http\JsonResponse;
use \OCP\AppFramework\Controller;

use \OCA\ExifView\Storage\PhotoStorage;
use \OCA\ExifView\Db\PhotoDBO;

class JsonController extends Controller {

	private $userId;
	private $storage;
	private $dbh;

	public function __construct(
		$AppName,
		$UserId,
		IRequest $request,
		PhotoStorage $storage
	) {
		parent::__construct($AppName, $request);

		$this->userId = $UserId;
		$this->storage = $storage;
	}

	public function index() {

		return new JsonResponse($this->storage->list_files());
	}


	public function show($fileid) {
		
		return new JsonResponse($this->storage->get_exifheader($fileid));
	}
}
