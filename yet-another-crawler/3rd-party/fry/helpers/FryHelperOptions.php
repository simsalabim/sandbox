<?php

/**
 * Dynamic creation of slects options
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryHelperOptions.php 16 2007-05-15 10:21:15Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

/**
 * Dynamic creation of slects options
 * 
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryHelperOptions extends FryHelper {
	
	private $output;
	
	public function __construct($params = array()) {
		if (is_array($params[0])) {
			foreach ($params[0] as $k => $v) {
				$k = (string)$k;
				$v = (string)$v;
				
				$selected = null;
				if (isset($params[1]) && $params[1] == $k) {
					$selected = ' selected="selected"';
				}
				
				$this->output .= "<option value=\"$k\"$selected>$v</option>\n";
			}			
		} else {
			throw new FryHelperException(
					'Array should be passed for options creation');	
		}
	}
	
	public function output() {
		return $this->output;
	}
}

?>