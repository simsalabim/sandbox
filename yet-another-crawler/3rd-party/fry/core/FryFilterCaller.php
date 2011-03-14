<?php

/**
 * FryFilterCaller
 * 
 * @example FryFilterCaller::getInstance('string to filter')->f1()->f2()->get()
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryFilterCaller.php 56 2007-10-05 21:05:06Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

ini_set('include_path', get_include_path() . PATH_SEPARATOR . 
		dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'filters');

/**
 * FryFilterCaller
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryFilterCaller {
	
	/**
	 * FryFilterCaller
	 *
	 * @var FryFilterCaller
	 */
	private static $instance = null;
	
	/**
	 * Value (string, object, int) which we'll filter
	 *
	 * @var mixed
	 */
	private $value;
	
	private function __construct($value) {
		$this->value = $value;
	}
	
	/**
	 * Get FryFilterCaller
	 *
	 * @param mixed $value
	 * @return FryFilterCaller
	 */
	public static function getInstance($value) {
		if (self::$instance instanceof FryFilterCaller) {
			self::$instance->set($value);
			return self::$instance;
		} else {
			self::$instance = new FryFilterCaller($value);
			return self::$instance;
		}
	}
	
	/**
	 * Set value with which we work (filter)
	 *
	 * @param mixed $value
	 * @return FryFilterCaller
	 */
	public function set($value) {
		$this->value = $value;
		return $this;
	}
	
	/**
	 * Get filtered value
	 *
	 * @return mixed
	 */
	public function get() {
		return $this->value;
	}
	
	/**
	 * Call some concrete filter
	 *
	 * @param string $name
	 * @param array $arguments
	 * @return FryFilterCaller
	 */
	public function __call($name, $arguments) {
		$class = "FryFilter" . ucfirst($name);
		$return = @include_once $class . '.php';

		if ($return && class_exists($class)) {
			$object = new $class($this);
			return $object->filter();	
		}
		
		throw new FryNoCallableException(
				"Can't load non existing filter: $class");
		
	}
}

?>