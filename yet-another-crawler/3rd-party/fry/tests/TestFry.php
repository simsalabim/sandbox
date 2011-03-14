<?php

/**
 * Tests for Fry
 *
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: TestFry.php 31 2007-07-05 08:23:30Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once '../core/Fry.php';

/**
 * Tests for Fry and FryTemplate functionality
 *
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class TestFry extends UnitTestCase {

	function testRender() {
		$t = new FryTemplate("tpl/master.php");
		$fry = new Fry();
		$fry->setTemplate($t);
		$this->assertEqual($fry->render(), "master");
	}

	function testRenderPart() {
		$t = new FryTemplate("tpl/part.php");
		$fry = new Fry();
		$fry->setTemplatePart('something', $t);
		$this->assertEqual($fry->renderPart('something'), "part");
	}

	function testDeepNestingAndTemplateVariables() {
		$t1 = new FryTemplate("tpl/deep_master.php");
		$t2 = new FryTemplate("tpl/second.php");
		$t3 = new FryTemplate("tpl/part.php");
   
		$t2->set('var', 1);
		$expecting = "master1part";

		$fry = new Fry();
		$fry->setTemplate($t1);
		$fry->setTemplatePart('second', $t2);
		$fry->setTemplatePart('part', $t3);
		$this->assertEqual($fry->render(), $expecting);
	}

	function testVariableSettingAndGetting() {
		$fry = new Fry();
		$t = new FryTemplate('tpl/testvars.php');
		$fry->setTemplate($t);
		$t->someVar = "value";
		$this->assertEqual($t->get('someVar'), "value");
		$this->assertEqual($t->someVar, "value");
		$t->set('variable', 1);
		$this->assertEqual($fry->render(), "11");
		$t->set('variable', '');
		$this->assertEqual($fry->render(), '');
	}


	function testFindTemplates() {
		$t = new FryTemplate("part.php");
		$fry = new Fry();
		$fry->setTemplate($t);
		$this->expectException();
		$fry->render();
   
		$t = new FryTemplate("part.php");
		$t->addPath('tpl');
		$fry = new Fry();
		$fry->setTemplate($t);
		$this->assertEqual($fry->render(), "part");
	}

	function testConfigPassing() {
		$fry = new Fry(new FryConfig('config/config.xml'));
		$t = new FryTemplate("part.php");
		$fry->setTemplate($t);
		$this->assertEqual(count($t->getPosiblePaths()), 2);

		$fry = new Fry(new FryConfig('config/config.php'));
		$t = new FryTemplate("part.php");
		$fry->setTemplate($t);
		$this->assertEqual(count($t->getPosiblePaths()), 2);
	}

	function testWorkWithPaths() {
		$fry = new Fry(new FryConfig('config/config.xml'));
		$t = new FryTemplate("part.php");
		$fry->setTemplate($t);
		$this->assertEqual(count($t->getPosiblePaths()), 2);
		$t->addPath('asdf');
		$this->assertEqual(count($t->getPosiblePaths()), 3);
		$t->removePath('asdf');
		$this->assertEqual(count($t->getPosiblePaths()), 2);
		$t->removePath();
		$this->assertEqual(count($t->getPosiblePaths()), 0);
	}
	
	function testSetAndGetTemplate() {
		$t = new FryTemplate("tpl/master.php");
		$fry = new Fry();
		$fry->setTemplate($t);
		$this->assertEqual($fry->getTemplate(), $t);
		$fry->setTemplatePart('whatever', $t);
		$this->assertEqual($fry->getTemplatePart('whatever'), $t);
	}
}

$test = new TestFry();
$test->run(new HtmlReporter());

?>