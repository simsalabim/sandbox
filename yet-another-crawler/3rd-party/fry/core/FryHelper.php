<?php

/**
 * Abstract FryHelper - plugin to generate HTML code
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryHelper.php 53 2007-08-17 15:43:51Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

class FryHelperException extends Exception {}

/**
 * Abstract class for FryHelpers
 * 
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
abstract class FryHelper {
	
	/**
	 * Constructor for helper
	 * Should do all processing for helper
	 *
	 * @param array $params
	 * @throws FryHelperException
	 */
	abstract function __construct($params = array());
	
	/**
	 * Output should return generated HTML code
	 * 
	 * @return string HTML code
	 */
	abstract function output();
	
	/**
	 * Generate HTML attributes from array(k => v, ...)
	 *
	 * @param array $array
	 * @return string
	 */
	public function generateAttributes($array) {
		$attributes = null;
		
		if (is_array($array)) {
			foreach ($array as $attribute => $value) {
				if (is_string($attribute)) {
					$attributes .= " " . $attribute . '="' . $value . '"';
				}
			}
		}
		
		return $attributes;
	}
}

?>