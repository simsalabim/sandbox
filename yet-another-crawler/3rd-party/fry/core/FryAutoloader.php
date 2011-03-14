<?php

/**
 * Fry internal autoloading
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryAutoloader.php 57 2007-10-05 22:08:23Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

function fry_autoloader($class) {
	@include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . $class . '.php';
}

$autoloaders = spl_autoload_functions();
spl_autoload_register('fry_autoloader');

/*
 * "... spl_autoload_register() will effectively replace the engine cache for 
 * the __autoload function by either spl_autoload() or spl_autoload_call()."
 *   -- php manual
 * 
 * Let's fix that if user has used __autoload()
 */
if (in_array('__autoload', (array) $autoloaders)) {
	spl_autoload_register('__autoload');
}

?>