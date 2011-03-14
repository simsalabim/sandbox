<?php

/**
 * FryHelperDoSomeStuff - user fry helper example
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryHelperDoSomeStuff.php 55 2007-08-30 12:34:12Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */
 
/**
 * FryHelperDoSomeStuff - user fry helper example
 * 
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryHelperDoSomeStuff extends FryHelper {
	
	private $string;

	public function __construct($params = array()) {
		$prm = @implode(', ', $params);
		$this->string = 'You have called doSomeStuff with params: ' . $prm;
	}
	
	public function output() {
		return $this->string;
	}
}

?>