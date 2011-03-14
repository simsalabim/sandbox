<?php

/**
 * TestFryDictionary
 *
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: TestFryDictionary.php 56 2007-10-05 21:05:06Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once '../core/FryDictionary.php';

/**
 * TestFryDictionary
 *
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class TestFryDictionary extends UnitTestCase {

	function testGetVariableXML() {
		$dict = new FryDictionaryXML('dict/dict.xml');
		$this->assertEqual($dict->get('some'), 'Some var');
	}
	
	function testNonExistingDictFileXML() {
		$this->expectException();
		$dict = new FryDictionaryXML('3kj456');
	}
	
	function testGetVariablePHP() {
		$dict = new FryDictionaryPHP('dict/dict.php');
		$this->assertEqual($dict->get('name'), 'value');
		$this->assertEqual($dict->get('complex'), array(0, 1, 2));
	}
	
	function testGetVariableIni() {
		$dict = new FryDictionaryIni('dict/dict.ini');
		$this->assertEqual($dict->get('var'), 'value');
		$this->assertEqual($dict->get('stuff'), 'good');
		$this->assertEqual($dict->get('whatever'), null);
	}

}

$test = new TestFryDictionary();
$test->run(new HtmlReporter());

?>