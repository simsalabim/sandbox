<?php

/**
 * Example of Fry usage
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: index.php 34 2007-07-07 13:13:14Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', true);

require_once dirname(dirname(dirname(__FILE__))) . "/core/Fry.php";

try {
	
	// initialise Fry system, if you want, pass a config
	$fry = new Fry(new FryConfig('config/config.xml'));
	$fry->setGlobal('something', 'Global text, not form menu template');
	
	// main template, holder for subtemplates
	// + we set a local variable for this template
	$main = new FryTemplate("main.tpl.php");
	$main->set('title', 'Fry example 1');
	
	// menu template
	$menu = new FryTemplate("menu.tpl.php");
	
	// content template
	// + we set a local variable without using a setter
	$content = new FryTemplate("content.tpl.php");
	$content->advertisement = array(
		"Object oriented",
		"Fast",
		"Secure",
		"Developed using Test Driven Development (TDD)",
		"Easy to learn",
		"Light weight"
	);
	
	$footer = new FryTemplate("footer.tpl.php");
	
	// here we add all these templates to Fry, one main and other as parts
	$fry->setTemplate($main);
	$fry->setTemplatePart('menu', $menu);
	$fry->setTemplatePart('content', $content);
	$fry->setTemplatePart('footer', $footer);
	
	// render and output page
	echo $fry->render();
	
// here we catch general Exception, but we have an ability to catch distict 
// exceptions for each Fry component, and take different actions on each
} catch (Exception $e) {
	
	ob_clean(); // not to see partly rendered templates output
	echo "<b>Error:</b><br/>\n" . $e->getMessage() 
			. "<br/>\n<b>Trace:</b><br/>\n" 
			. preg_replace("/(\n)|(\r\n)/", "\\1<br/>", $e->getTraceAsString());
}

?>