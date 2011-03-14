<?php

/**
 * Template class, each template is new FryTemplate object
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryTemplate.php 53 2007-08-17 15:43:51Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

class FryTemplateException extends Exception {}

/**
 * Holds template info and variables
 * 
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryTemplate {
	
	/**
	 * Template filename
	 *
	 * @var String
	 */
	private $file;
	
	/**
	 * Array containing possible paths (dirs) to a template
	 *
	 * @var array
	 */
	private $path = array();
	
	/**
	 * Array of template's variables
	 *
	 * @var array
	 */
	private $variables = array();
	
	/**
	 * Should fry cache this template?
	 * 
	 * @var bool
	 */
	private $cache = false;
	
	/**
	 * Cache lifetime
	 * 
	 * @var int
	 */
	private $cache_time = 300;
	
	
	public function __construct($file) {
		$this->file = $file;
	}
	
	/**
	 * Set template's variable
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function set($name, $value = null) {
		$this->variables[$name] = $value;
	}
	
	/**
	 * Get template's variable
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function get($name) {
		return isset($this->variables[$name]) ? $this->variables[$name] : null;
	}
	
	/**
	 * Overloader for setting variable without setter, as template's property
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) {
		return $this->set($name, $value);
	}
	
	/**
	 * Overloader for getting variable without getter, as template's property
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name) {
		return $this->get($name);
	}
	
	/**
	 * Get template's path
	 *
	 * @throws FryTemplateException
	 * @return string
	 */
	public function getPath() {
		if (file_exists($this->file)) {
			return realpath($this->file);
		}
		
		foreach ($this->path as $path) {
			// remove last directory separator
			if ($path{strlen($path) - 1} == DIRECTORY_SEPARATOR) {
				$path = substr($path, 0, -1);
			}
			
			if (file_exists($path . DIRECTORY_SEPARATOR . $this->file)) {
				return realpath($path . DIRECTORY_SEPARATOR . $this->file);
			}
		}
		
		throw new FryTemplateException('Can\'t find template ' . $this->file
				. ", template path is " 
				. FryFunctions::arrayToString($this->path));
	}
	
	/**
	 * Add path in which to search for a template
	 *
	 * @throws FryTemplateException
	 * @param string $path
	 */
	public function addPath($path) {
		if (is_string($path)) {
			$this->path[] = $path;
		} else {
			throw new FryTemplateException("Can't add " . gettype($path) 
					. " as path");
		}
	}

	/**
	 * Remove all or concrete element from template's path
	 *
	 * @param string $path
	 * @throws FryTemplateException
	 * @return boolean
	 */
	public function removePath($path = null) {
		if (is_null($path)) {
			$this->path = array();
			return true;
		}
		
		$key = array_search($path, $this->path);
		
		if (is_int($key)) {
			unset($this->path[$key]);
			return true;
		}
		throw new FryTemplateException('Can\'t remove non existing path ' 
				. $path);
	}
	
	/**
	 * Return array of paths in which template will be searched
	 *
	 * @return array
	 */
	public function getPosiblePaths() {
		return $this->path;
	}
	
	/**
	 * Enable caching of this template, optionaly pass cache time.
	 *
	 * @param int $time
	 */
	public function cache($time = null) {
		$this->cache = true;
		!is_null($time) && ($this->cache_time = (int) $time);
	}

	/**
	 * Set time in seconds for cache to be alive
	 * 
	 * @param int $time
	 */
	public function setCacheTime($time) {
		$this->cache_time = (int) $time;
	}
	
	/**
	 * Check if template is cached
	 * 
	 * @return bool
	 */
	public function isCached() {
		return $this->cache;
	}
	
	/**
	 * Get time of caching in seconds
	 * 
	 * @return int;
	 */
	public function getCacheTime() {
		return $this->cache_time;
	}
}

?>