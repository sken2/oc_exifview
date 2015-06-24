<?php
namespace OCA\ExifView\Db;

use \OCP\IDb;

class PhotoDBO {

	private $db;

	public function __construct(IDb $db) {
		$this->db = $db;
	}

	public function hoge() {

	}
}
