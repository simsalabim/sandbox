<?php

/**
 * Dummy helper to test user helpers functionality
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryHelperTest.php 14 2007-05-14 10:32:40Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

/**
 * Test user helpers
 * 
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryHelperTest extends FryHelper {

	public function __construct($params = array()) {
	}
	
	public function output() {
		return "I do work";
	}
}

?>