<?php

/**
 * FryDictionary implementation to read PHP ini dictionary
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryDictionaryIni.php 56 2007-10-05 21:05:06Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

/**
 * FryDictionary implementation to read PHP ini dictionary
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryDictionaryIni implements FryDictionary {
	
	/**
	 * Dictionary
	 *
	 * @var array
	 */
	public $dictionary;
	
	public function __construct($file) {
		$this->dictionary = parse_ini_file($file);
		if (!is_array($this->dictionary)) {
			throw new FryDictionaryException(
					'Failded to load dictionary: ' . $file);
		}
	}
	
	public function get($variable) {
		return isset($this->dictionary[$variable]) 
			   ? $this->dictionary[$variable]
			   : null;
	}
}

?>