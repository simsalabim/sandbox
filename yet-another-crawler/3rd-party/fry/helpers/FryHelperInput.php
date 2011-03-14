<?php

/**
 * FryHelper for generation of input HTML tag
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryHelperInput.php 14 2007-05-14 10:32:40Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */
 
/**
 * FryHelper which creates inputs
 * 
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryHelperInput extends FryHelper {
	
	/**
	 * String containing generated input
	 *
	 * @var string
	 */
	private $input;
	

	public function __construct($params = array()) {
		
		if (count($params) < 2) {
			throw new FryHelperException('Wrong number of parameters');
		}
		
		$attributes = null;
		
		if (isset($params[2])) {
			$attributes = $this->generateAttributes($params[2]);
		}
		
		$this->input = "<input type=\"{$params[0]}\" " 
				. "name=\"{$params[1]}\"$attributes/>";
	}
	
	public function output() {
		return $this->input;
	}
}

?>