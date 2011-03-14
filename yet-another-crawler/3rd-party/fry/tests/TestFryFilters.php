<?php

/**
 * TestFryFilter
 *
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: TestFryFilters.php 44 2007-07-17 16:55:35Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once '../core/FryFilterCaller.php';

/**
 * TestFryFilter
 *
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class TestFryFilter extends UnitTestCase {

	function testFilteringAndLeaveNumbersFilter() {
		$result = FryFilterCaller::getInstance('a3465sdf123')
					->upper()
					->leaveNumbers()
					->get();
		$this->assertEqual(3465123, $result);
	}
	
	function testStrToUpperFilter() {
		$result = FryFilterCaller::getInstance('asdf')
					->upper()
					->get();
		$this->assertEqual('ASDF', $result);
	}
	
	function testNoCallableException() {
		$this->expectException();
		FryFilterCaller::getInstance('asdf')->callingWhateverAhahaaa();	
	}
	
	function testSingletonWithValueSetting() {
		$result1 = FryFilterCaller::getInstance('one')->upper()->get();
		$result2 = FryFilterCaller::getInstance('two')->upper()->get();
		$this->assertEqual('ONE', $result1);
		$this->assertEqual('TWO', $result2);
	}

}

$test = new TestFryFilter();
$test->run(new HtmlReporter());

?>