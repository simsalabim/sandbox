<?php

/**
 * FryDictionary implementation to read XML dictionary
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryDictionaryXML.php 56 2007-10-05 21:05:06Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

/**
 * FryDictionary implementation to read XML dictionary
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryDictionaryXML implements FryDictionary {
	
	/**
	 * Dictionary
	 *
	 * @var SimpleXMLElement
	 */
	public $xml;
	
	public function __construct($file) {
		if (file_exists($file)) {
			$this->xml = simplexml_load_file($file);
		} else {
			throw new FryDictionaryException(
					'XML file: ' . $file . 'does not exists.');
		}
	}
	
	public function get($variable) {
		foreach ($this->xml->variable as $var) {
			if ((string) $var['name'] == $variable) {
				return (string) $var;
			}
		}
		return null;
	}
}

?>