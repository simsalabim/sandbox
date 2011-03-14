<?php

/**
 * FryFilter
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryFilter.php 56 2007-10-05 21:05:06Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

/**
 * Abstract FryFilter
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
abstract class FryFilter {
	
	/**
	 * FryFilterCaller
	 *
	 * @var FryFilterCaller
	 */
	protected $caller;
	
	public function __construct(FryFilterCaller $caller) {
		$this->caller = $caller;
	}
	
	/**
	 * Filter string, set it to FryFilterCaller, return FryFilterCaller
	 *
	 * @return FryFilterCaller
	 */
	abstract public function filter();
}

?>