<?php

/**
 * Group tests for Fry functionality
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: index.php 44 2007-07-17 16:55:35Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';

$test = new GroupTest('All tests');
$test->addTestFile('TestFry.php');
$test->addTestFile('TestFryHelpers.php');
$test->addTestFile('TestFryDictionary.php');
$test->addTestFile('TestFryFilters.php');
$test->run(new HtmlReporter());

?>