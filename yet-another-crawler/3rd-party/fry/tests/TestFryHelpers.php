<?php

/**
 * Tests for FryHelpers
 *
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: TestFryHelpers.php 18 2007-05-21 20:31:02Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once '../core/Fry.php';

/**
 * Tests for FryHelpers functionality
 *
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class TestFryHelpers extends UnitTestCase {

	function testNonExistingHelperException() {
		$fry = new Fry();
		$this->expectException();
		$fry->callingNonExistingHelper("param 1", "param 2");
	}

	function testLink() {
		$fry = new Fry();
		$link = '<a href="http://www.google.com" class="green" style="">l</a>';
		$fryLink = $fry->link("http://www.google.com", "l",
				array('class' => 'green', 'style' => ''));
		$this->assertEqual($link, $fryLink);
	}

	function testLinkWrongNumberOfParamsException() {
		$fry = new Fry();
		$this->expectException();
		$fry->link();
	}

	function testDate() {
		$fry = new Fry();
		$fry->selectDate();
		$fry->selectDate(array('year' => 'Y', 'month' => 'm'),
				array('separator' => '', 'from' => 30));
		$fry->selectDate(array('year' => 'Y'));
		$fry->selectDate(array('month' => 'F'));
		$fry->selectDate(array('day' => 'd'));
	}

	function testInputGeneration() {
		$fry = new Fry();
		$fry->input('text', 'name', array('value' => 'Viktoras'));
		$fry->input('password', 'pass');
		$fry->input('text', 'occupation',
				array('value' => 'Programmer', "disabled" => "disabled"));
		$fry->input('checkbox', 'choose1', 
				array('value' => 'one', 'checked' => 'checked'));
		$fry->input('checkbox', 'choose2', array('value' => 'two'));
		$fry->input('submit', 'submit');
		$fry->input('button', 'whatever', array('value' => 'button'));
		$fry->input('radio', 'rdo', array('value' => 1));
		$fry->input('radio', 'rdo', 
				array('value' => 2, 'checked' => 'checked'));
	}

	function testUserHelperPathFromConfig() {
		$fry = new Fry(new FryConfig('config/config.xml'));
		$this->assertEqual($fry->test(), 'I do work');
	}

	function testOptionsGenerator() {
		$fry = new Fry();

		$options1 = array(1 => 'One', 'some' => 'Two');
		$result1 = "<option value=\"1\">One</option>\n";
		$result1 .= "<option value=\"some\">Two</option>\n";
		$this->assertEqual($fry->options($options1), $result1);
   
		$options2 = array('one', 'two', 'three');
		$result2 = "<option value=\"0\">one</option>\n";
		$result2 .= "<option value=\"1\">two</option>\n";
		$result2 .= "<option value=\"2\" selected=\"selected\">three</option>\n";
		$this->assertEqual($fry->options($options2, 2), $result2);
   
		$this->expectException();
		$fry->options('something');
	}
}

$test = new TestFryHelpers();
$test->run(new HtmlReporter());

?>