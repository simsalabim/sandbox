<?php

/**
 * FryDictionary interface
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryDictionary.php 56 2007-10-05 21:05:06Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

class FryDictionaryException extends Exception {}

/**
 * Interface FryDictionary for i18n
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
interface FryDictionary {

	public function __construct($file);

	public function get($variable);
}

?>