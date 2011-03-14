<?php

/**
 * FryDictionaryFactory
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryDictionaryFactory.php 59 2007-10-21 19:24:01Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

require_once FRY_ROOT . '/FryDictionary.php';

/**
 *  FryDictionaryFactory to load appropriate dictionary implementation 
 *  by dictionary file extension
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryDictionaryFactory {

	public static function load($file) {
		if (!file_exists($file)) {
			throw new FryDictionaryException('File does not exists: ' . $file);
		}
		
		switch (strtolower(FryFunctions::getExtension($file))) {
			case 'xml':
				return new FryDictionaryXML($file);
			case 'php':
				return new FryDictionaryPHP($file);
			case 'ini':
				return new FryDictionaryIni($file);
			default:
				throw new FryDictionaryException('Unsupported dictionary file');
			break;
		}
	}
}

?>