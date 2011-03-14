<?php

/**
 * Cache for FryTemplate
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryCache.php 53 2007-08-17 15:43:51Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

class FryCacheException extends Exception {}

/**
 * Cache for FryTemplate
 * 
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryCache {
	
	/**
	 * Cache name, full template path is suitable for that
	 *
	 * @var string
	 */
	private $name;
	
	/**
	 * md5 hash of $this->name
	 * 
	 * @var string
	 */
	private $hash;
	
	/**
	 * Cache directory
	 * 
	 * @var string dir
	 */
	private $dir;
	
	/**
	 * Full path of a cache file
	 * 
	 * @var string
	 */
	private $path;
	
	
	/**
	 * Cache lifetime in seconds
	 * 
	 * @var int
	 */
	private $lifetime;
	
	/**
	 * FryCache constructor
	 *
	 * @param string $name cache id, full template path is perfect for it
	 * @param unknown_type $dir directory for cache files
	 */
	public function __construct($name, $lifetime = 300, $dir = 'cache') {
		$this->name = $name;
		$this->hash = md5($name);
		$this->dir = $dir;
		$this->lifetime = $lifetime;
		$this->path = realpath($this->dir) . DIRECTORY_SEPARATOR . $this->hash;
	}
	
	public function getCache() {
		if ($this->cacheExists() && $this->valid()) {
			return file_get_contents($this->path);
		}
		return false;
	}
	
	public function setCache($string) {
		if ($this->dirExists() && $this->fileIsWritable()) {
			if (($fp = fopen($this->path, 'w')) && flock($fp, LOCK_EX)) {
				fwrite($fp, $string);
				flock($fp, LOCK_UN);
				@fclose($fp);
			} else {
				throw new FryCacheException('Failed to write to a cache file ' .
						$this->path);
			}
		}
	}
	
	private function cacheExists() {
		return file_exists($this->path);
	}
	
	private function dirExists() {
		if (is_dir($this->dir)) {
			return true;
		}
		throw new FryCacheException('Cache directory "' . 
				$this->dir . '" does not exists');
	}

	private function fileIsWritable() {
		if (is_writable($this->dir)) {
			return true;
		}
		throw new FryCacheException('Cache directory is not writable. ' . 
				'Directory is: ' . $this->dir);
	}
	
	private function valid() {
		if ($this->cacheExists()) {
			return (filemtime($this->path) + $this->lifetime) >= time();
		}
	}
}

?>
