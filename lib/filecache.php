<?php
namespace OCA\ExifView\Lib;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Filecache extends Entity implements JsonSerializable {

	protected $fileid;
	protected $storage;
	protected $path;
	protected $path_hash;
	protected $parent;
	protected $name;
	protected $mimetype;
	protected $mimepart;
	protected $size;
	protected $mtime;
	protected $storage_mtime;
	protected $encrypted;
	protected $unencrypted_size;
	protected $etag;
	protected $permissions;

	public function jsonSerialize(){
		return [
			'fileid'=> $this->fileid,
			'storage'=> $this->storage,
			'path'=> $this->path,
			'path_hash'=> $this->path_hash,
			'parent'=> $this->parent,
			'name'=> $this->name,
			'mimetype'=> $this->mimetype,
			'mimepart'=> $this->mimepart,
			'size'=> $this->size,
			'mtime'=> $this->mtime,
			'storage_mtime'=> $this->storage_mtime,
			'encrypted'=> $this->encrypted,
			'unencrypted_size'=> $this->unencrypted_size,
			'etag'=> $this->etag,
			'permissions'=> $this->permissions,
		];
	}
}
