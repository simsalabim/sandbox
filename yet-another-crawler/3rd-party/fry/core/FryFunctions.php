<?php

/**
 * Fry helper functions
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryFunctions.php 56 2007-10-05 21:05:06Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */


/**
 * Small helper functions for Fry
 * 
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryFunctions {
	
	/**
	 * Convert an array to comma separated string
	 *
	 * @param array $array
	 * @return string
	 */
	public static function arrayToString($array) {
		$parts = null;
		
		foreach($array as $k => $v) {
			$value = is_string($k) ? $k : $v;
			$s = !is_null($parts) ? ", " : null;
			$parts .= $s . $value;
		}
		
		return $parts;
	}
	
	/**
	 * Cleans all contents in output buffers and rethrows exception
	 *
	 * @param mixed $e various types of exceptions
	 */
	public static function cleanOutputAndRethrowException($e) {
		$level = ob_get_level();
		
		for ($i = 1; $i <= $level; $i++) {
			ob_end_clean();
		}
		
		throw $e;
	}
	
	/**
	 * Return extension of a filename
	 *
	 * @param string $filename
	 * @return string
	 */
	public static function getExtension($filename) {
		$exploded = array();
		$extension = '';
		$exploded = explode('.', $filename);
		
		if (count($exploded) > 1) {
			$extension = array_pop($exploded);
		}
		
		return $extension;
	}
}

?>