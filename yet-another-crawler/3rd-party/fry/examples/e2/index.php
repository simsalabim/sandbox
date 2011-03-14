<?php

/**
 * Example of Fry + FryDictionary usage
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: index.php 56 2007-10-05 21:05:06Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', true);

require_once dirname(dirname(dirname(__FILE__))) . "/core/Fry.php";

try {
	$lang = 'en';
	
	if (isset($_GET['lang']) && in_array($_GET['lang'], array('lt', 'en'))) {
		$lang = $_GET['lang'];
	}
	
	$fry = new Fry(new FryConfig('config/config.xml'));
	$fry->setDictionary(FryDictionaryFactory::load(("dict/dict_$lang.xml")));

	$main = new FryTemplate("main.tpl.php");
	$menu = new FryTemplate("menu.tpl.php");
	$content = new FryTemplate("content.tpl.php");
	
	$fry->setTemplate($main);
	$fry->setTemplatePart('menu', $menu);
	$fry->setTemplatePart('content', $content);

	echo $fry->render();
	
} catch (Exception $e) {
	
	@ob_clean();
	echo "<b>Error:</b><br/>\n" . $e->getMessage() 
			. "<br/>\n<b>Trace:</b><br/>\n" 
			. preg_replace("/(\n)|(\r\n)/", "\\1<br/>", $e->getTraceAsString());
}

?>