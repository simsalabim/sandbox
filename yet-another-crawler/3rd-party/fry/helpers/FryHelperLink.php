<?php

/**
 * FryHelper for generation of <a> HTML tag
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryHelperLink.php 14 2007-05-14 10:32:40Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

/**
 * FryHelper for generation of <a> HTML tag
 * 
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryHelperLink extends FryHelper {
	
	/**
	 * String containing generated link
	 *
	 * @var string
	 */
	private $link;
	
	/**
	 * Fry link should be called from Fry object
	 * with 3 params: ulr, link name, array of options
	 *
	 * @param array $params ulr, link name, array of options
	 */
	public function __construct($params = array()) {
		
		if (count($params) < 2) {
			throw new FryHelperException('Wrong number of parameters');
		}
		
		$attributes = null;
		
		if (isset($params[2])) {
			$attributes = $this->generateAttributes($params[2]);
		}
		
		$this->link = "<a href=\"{$params[0]}\"{$attributes}>{$params[1]}</a>";
	}
	
	public function output() {
		return $this->link;
	}
}

?>