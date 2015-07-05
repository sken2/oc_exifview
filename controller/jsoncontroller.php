<?php
namespace OCA\ExifView\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\JsonResponse;
use OCP\AppFramework\Controller;

use OCA\ExifView\Service\PhotoStorage;
use OCA\ExifView\Db\PhotoDBO;

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


	public function show($path) {
//return new jsonResponse($path);
		return new JsonResponse($this->storage->get_exifheader($path));
	}

	public function showgps($path) {
//return new jsonResponse($path);
		return new JsonResponse($this->storage->get_exif_location($path));
	}

	public function time($path) {
//		$path=urldecode($path);
		return new JsonResponse($this->storage->get_exiftime($path));
	}

	public function test($foo) {
		return new JsonResponse($this->storage->test());
//		return array('hoge');
	}
}
