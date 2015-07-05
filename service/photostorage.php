<?php

namespace OCA\ExifView\Service;

use Exception;

use OC\Files\View;
use OC\Files\Filesystem;

use OCP\IDbConnection;


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

		//! something wrong with searchByMime, this not returns relative-path
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

			$exif = exif_read_data($this->getLocalFile($path),'FILE,GPS');
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
			$localPath = $this->getLocalFile($path);
			$exif = exif_read_data($localPath);
			if (!$exif) {
				return array();
			}
			$timestr = $exif['DateTimeOriginal'];
			$dt = new \DateTime($timestr, new \DateTimeZone('Asia/Tokyo'));
			$epoch = $dt->format('U'); //!TZ did not came from file
			return array('FileDateTime'=> $epoch);
		} catch (\Exception $e) {
			throw new Exception('oops') ;
		}
	}

	/**
	 * @param string img file path
	 * @return array(lat, lon)
	 */
	public function get_exif_location($path) {
		$localPath = $this->getLocalFile($path);
		$exif = exif_read_data($localPath, 'FILE,GPS', true);
		
		$lat = $this->denomToValue($exif['GPS']['GPSLatitude']);
		$lon = $this->denomToValue($exif['GPS']['GPSLongitude']);
		return array($lat, $lon);
	}

	protected function denomToValue($denom_array) {
		$value = 0;
		$unit = 1;
		foreach($denom_array as $i => $denom){
			list($number, $subunit) = explode('/', $denom);
			$value += $number * $unit / $subunit ;
			$unit = $unit / 60 ;
		}
		return $value;
	}
	protected function hasExifHeader($node){
		$exif = exif_read_data($this->getLocalFile($node->getPath()));
		return (bool)$exif;
	}

	protected function getLocalFile($path) {
//		$mt = $this->storage->getMountPoint($path);
//		$lf = $this->storage->getLocalFile($path);
//		$lp = $this->storage->getLocalPath($path);
//All staffs around localfile are buggy and useless
		$lp = '/home/shi/owncloud/data'.$path;
//		$lp = $lf.$lp;
		return $lp;
	}

	public function test() {
		return $this->storage->getRoot();//that's returns /shi/files
	}
}
