<?php

namespace OCA\ExifView\Service;

use \Exception;

use \OC\Files\View;
use \OC\Files\Filesystem;

use \OCP\IDbConnection;


class PhotoStorage {

	private $appname;
	private $userId;
	private $storage;
	private $db;

	public function __construct(
		$AppName,
		$UserId,
		Filesystem $storage,
		IDbConnection $db
	) {
		$this->appname = $AppName;
		$this->userId = $UserId;
		$this->storage = $storage;
		$this->db = $db;
	}

	public function list_files($path = null){
		$r = array() ;

		$img_nodes = $this->storage->searchByMime('image');

		foreach ($img_nodes as $node) {
			$has_exif = $this->hasExifHeader($node);
			$fileid=$node->getId();
			$r[]=array(
				'fileid' => $fileid,
				'path' => $node->getPath(),
				'exif' => $has_exif
			);
		}
		return $r;
	}

	public function get_exifheader($path) {
		try {
			if(!$path){
				return false;
			}

			$exif = exif_read_data($this->getLocalFile($path));
			if(!$exif) {
				return array();
			}
			return $exif;
		} catch (\Exception $e) {
			throw new Exception('oops');
		}
	}

	public function get_exiftime($path) {
		try {

			if(!$path) {
				return false;
			}
//return $this->getLocalFile($path);
			$exif = exif_read_data($this->getLocalFile($path));
//return $exif;
			if (!$exif) {
				return array();
			}
			return array('FileDateTime'=> $exif['FileDateTime']);
		} catch (\Exception $e) {
			throw new Exception('oops') ;
		}
	}

	protected function hasExifHeader($node){
		$exif = exif_read_data($this->getLocalFile($node->getPath()));
		return (bool)$exif;
	}

	protected function getLocalFile($path) {
//		$mt = $this->storage->getMountPoint($path);
//		$lf = $this->storage->getLocalFile($path);
//All staffs around localfile are buggy and useless
		$lp = '/home/shi/owncloud/data'.$path;
		return $lp;
	}
}
