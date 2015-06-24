<?php

namespace OCA\ExifView\Storage;

use \Exception;

use \OC\Files\Filesystem;

use \OCP\IDb;
//use \OCP\Files\Folder;
//use \OC\Files\Fileinfo;
use \OC\Files\Node;
use \OC\Files\Node\Folder;
use \OC\Files\View;
use \OC\Files\Node\Root;

use \OCP\AppFramework\Db\Mapper;
use \OCA\ExifView\Lib\Filecache;

class PhotoStorage {

	const realRoot='/home/shi/owncloud/data';

	private $storage;
	private $dbh;
	private $appname;
	private $userId;

	public function __construct(
		$AppName,
		$UserId,
		Filesystem $storage,
		Filesystem $appstorage,
		IDb $db
	) {
		$this->storage = $storage;
		$this->appstorage = $appstorage;
		$this->dbh = $db;
		$this->userId = $UserId;
		$this->appname = $AppName;
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

	public function get_exifheader($id) {
		try {
			$realRoot=$this->realStorageRoot();

			$appview = new \OC\Files\View('/');

//			$path = $this->storage->getPath($id);
			$path = $appview->getPath($id); //!

			if(!$path){
				return "cant getPath for id =$id";
			}

			$realpath = $this->realStorageRoot().'/'.$path;

			$exif = exif_read_data($realpath);
			if(!$exif) {
				return "cant read file $realpath";
			}
			return $exif;

		} catch (\Exception $e) {
			throw new Exception('oops');
		}
	}

	protected function hasExifHeader($node){

		$realRoot=$this->realStorageRoot();
		$exif = exif_read_data($realRoot.$node->getPath());
		return (bool)$exif;
	}

	private function realStorageRoot(){
		return $this::realRoot;
	}
}
