<?php

/**
 * Configuration XML or PHP reader/parser
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryConfig.php 53 2007-08-17 15:43:51Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

class FryConfigException extends Exception {}

/**
 * Configuration reader/parser.
 * Can return configuration file as an array.
 * 
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryConfig {
	
	/**
	 * @var SimpleXMLElement $sx
	 */
	private $sx;
	
	/**
	 * Holds all config info
	 * 
	 * @var array $config
	 */
	protected $config = array();
	
	/**
	 * Create FryConfig
	 * Takes to types of config: xml file or php file which returns an array
	 * 
	 * @param string $config path to xml or php file
	 * @throws FryConfigException
	 */
	public function __construct($config = 'config/config.xml') {
		
		$temp = explode('.', $config);
		$ext = array_pop($temp);
		
		switch (strtolower($ext)) {
			case 'php':
				$array = @include $config;
				if (is_array($array)) {
					$this->config = $array;
				} else {
					throw new FryConfigException('Can\'t find config file or ' 
							. 'it does not return an array');
				}
				break;
			case 'xml':
				$xml = @file_get_contents($config);
				if ($xml) {
					$this->sx = @new SimpleXMLElement($xml);
					$this->config = self::SimpleXMLElementToArray($this->sx);
				} else {
					throw new FryConfigException("Can't find config file");
				}
				break;
			default:
				throw new FryConfigException('Unsupported config file type');
		}
		
	}
	
	/**
	 * Get part of config by first level key
	 * 
	 * @param string $part
	 * @return array config part
	 */
	public function get($part) {
		if (isset($this->config[$part])) {
			return $this->config[$part];
		}
		return null;
	}
	
	/**
	 * Set config part
	 * 
	 * @param string $part
	 * @param mixed $value
	 */
	public function set($part, $value) {
		$this->config[$part] = $value;
	}
	
	/**
	 * Returns all configuration file as array
	 * 
	 * @return array config
	 */
	public function getArray() {
		return $this->config;
	}
	
	/**
	 * Transformes SimpleXMLElement to array.
	 * 
	 * Attributes will be added to @key elements.
	 * 
	 * @param SimpleXMLElement $sx
	 * @return array
	 */
	protected static function SimpleXMLElementToArray(SimpleXMLElement $sx) {
		$array = array();
		$duplicate = false;
		
		if (count($sx) == 0) {
			return strval($sx);
		}
		
		/*
		 * Recursively run through all elements and add them to array
		 */
		foreach ($sx->children() as $k => $v) {		
			$child = self::SimpleXMLElementToArray($v);
			
			/*
			 * If first duplicate key - make multidimensional
			 */
			if (array_key_exists($k, $array) && !$duplicate) {
				$tmp = $array[$k];
				unset($array[$k]);
				$array[$k][] = $tmp;
				$array[$k][] = $child;
				$duplicate = true;
			/*
			 * Another duplicate key - just add to multidimensional
			 */
			} elseif (array_key_exists($k, $array) && $duplicate) {
				$array[$k][] = $child;
			/*
			 * Unique key - simply add to array
			 */
			} else {
				$array[$k] = $child;
			}
			
			/*
			 * Add all attributes
			 * They will be at [@key]
			 */
			foreach ($v->attributes() as $atribute => $value) {
				$array['@' . $k][][$atribute] = (string)$value;
			}
		}
		return $array;
	}
}

?>
