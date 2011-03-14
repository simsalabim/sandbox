<?php

/**
 * Example of Fry usage with user helpers
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: index.php 55 2007-08-30 12:34:12Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', true);

require_once dirname(dirname(dirname(__FILE__))) . "/core/Fry.php";

try {
	
	$fry = new Fry(new FryConfig('config/config.xml'));
	$main = new FryTemplate("main.tpl.php");
	$fry->setTemplate($main);
	echo $fry->render();

} catch (Exception $e) {
	
	@ob_clean();
	echo $e->getMessage();
}

?>