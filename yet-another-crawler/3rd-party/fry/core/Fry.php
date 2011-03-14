<?php

/**
 * Fast object oriented templating system for PHP5
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: Fry.php 59 2007-10-21 19:24:01Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

ini_set('include_path', get_include_path() . PATH_SEPARATOR . 
		dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'helpers');

define('FRY_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

require_once FRY_ROOT . '/FryAutoloader.php';

class FryException extends Exception {}
class FryNoCallableException extends Exception {}

/**
 * Fry templating system
 * 
 * @package Fry
 * @version 0.9.8.2
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class Fry {
	
	/**
	 * Master FryTemplate
	 *
	 * @var FryTemplate
	 */
	private $template;
	
	/**
	 * Array containing FryTemplates (parts of master template)
	 *
	 * @var array Array of FryTemplate objects
	 */
	private $templatePart = array();
	
	/**
	 * Object of current FryTemplate being parsed
	 *
	 * @var FryTemplate
	 */
	private $current = null;
	
	/**
	 * Fry configuration object
	 *
	 * @var FryConfig
	 */
	private $config;
	
	/**
	 * Gloabal variables
	 * 
	 * @var array
	 */
	private $variables = array();
	
	/**
	 * Dictionary
	 * 
	 * @var FryDictionary
	 */
	private $dictionary;
	
	
	public function __construct(FryConfig $config = null) {
		
		// stupid hack for E_STRICT
		date_default_timezone_set(@date_default_timezone_get());
		
		$this->config = $config;
	}
	
	/**
	 * Set master template
	 *
	 * @param FryTemplate $t
	 */
	public function setTemplate(FryTemplate $t) {
		$this->addTemplatePaths($t);	
		$this->template = $t;
	}
	
	/**
	 * Get master template
	 *
	 * @return FryTemplate
	 */
	public function getTemplate() {
		return $this->template;
	}
	
	/**
	 * Set template part
	 *
	 * @param string $part part name
	 * @param FryTemplate $t
	 */
	public function setTemplatePart($part, FryTemplate $t) {
		$this->addTemplatePaths($t);
		$this->templatePart[$part] = $t;
	}
	
	/**
	 * Get template part
	 *
	 * @param string $part part name
	 * @return FryTemplate
	 */
	public function getTemplatePart($part) {
		return isset($this->templatePart[$part]) ? $this->templatePart[$part] 
												 : null;
	}
	
	/**
	 * Render master template
	 *
	 * @throws FryException
	 * @return string
	 */
	public function render() {
		if (is_object($this->template)) {
			$this->current = $this->template;

			$render = true;
			
			if ($this->current->isCached()) {
				$render = false;
				$file = $this->current->getPath();
				$lifetime = $this->current->getCacheTime();
				$cache = new FryCache($file, $lifetime);
				if (($return = $cache->getCache()) === false) {
					$render = true;
				}
			}
			
			if ($render) {
				ob_start();
				
				// if there are any exceptions in templates, clean output 
				// and rethrow an exception
				try {
					include $this->template->getPath();
				} catch (FryTemplateException $e) {
					FryFunctions::cleanOutputAndRethrowException($e);
				} catch (FryException $e) {
					FryFunctions::cleanOutputAndRethrowException($e);
				} catch (Exception $e) {
					FryFunctions::cleanOutputAndRethrowException($e);
				}
				
				$return = ob_get_contents();
				ob_end_clean();
				isset($cache) && $cache->setCache($return);
			}
			
			$this->current = null;
			return $return;
		}
		throw new FryException("Can't render without any master template set");
	}
	
	/**
	 * Render template part
	 *
	 * @param string $part part name
	 * @throws FryException
	 * @return string
	 */
	public function renderPart($part) {
		if (!isset($this->templatePart[$part]) || 
				!is_object($this->templatePart[$part]) || 
				get_class($this->templatePart[$part]) != "FryTemplate") {
			throw new FryException("Template part '$part' is not set, " 
					. "set parts: "
					. FryFunctions::arrayToString($this->templatePart));			
		}
		
		$current = $this->current; // remember last template
		$this->current = $this->templatePart[$part];
		$render = true;
		
		// TODO refactor me
		if ($this->current->isCached() && !$this->template->isCached()) {
			$render = false;
			$file = $this->current->getPath();
			$lifetime = $this->current->getCacheTime();
			$cache = new FryCache($file, $lifetime);
			if (($return = $cache->getCache()) === false) {
				$render = true;
			}
		}
		
		if ($render) {
			ob_start();
			include $this->templatePart[$part]->getPath();
			$return = ob_get_contents();
			ob_end_clean();
			isset($cache) && $cache->setCache($return);
		}

		$this->current = $current; // set back last template
		return $return;
	}
	
	
	/**
	 * Set variable while in template (rendering process)
	 *
	 * @param string $name
	 * @param mixed $value
	 * @throws FryException
	 */
	public function set($name, $value) {
		if (is_object($this->current) 
				&& $this->current instanceof FryTemplate) {
			$this->current->set($name, $value);
		} else {
			throw new FryException('Can\'t set variable while not in template');
		}
	}
	
	/**
	 * Get variable while in template (rendering process)
	 * 
	 * @param string $name
	 * @throws FryException
	 * @return mixed
	 */
	public function get($name) {
		if (is_object($this->current) 
				&& $this->current instanceof FryTemplate) {
			if ($this->current->get($name) !== null) {
				return $this->current->get($name);
			} elseif ($this->dictionary instanceof FryDictionary) {
				return $this->dictionary->get($name);
			}
			return null;
		}
		throw new FryException('Can\'t get variable while not in template');
	}
	
	/**
	 * Overloading setter, probably won't be used
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) {
		return $this->set($name, $value);
	}
	
	/**
	 * Overloading getter, gets variable as property 
	 * from current template in rendering process
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name) {
		return $this->get($name);
	}
	
	/**
	 * Set global variable
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function setGlobal($name, $value) {
		$this->variables[$name] = $value;
	}
	
	/**
	 * Get global variable
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function getGlobal($name) {
		return isset($this->variables[$name]) ? $this->variables[$name] : null;
	}
	
	/**
	 * Call FryHelper and return some string output
	 *
	 * @param string $name FryHeper name without words FryHeper
	 * @param array $arguments
	 * @throws FryException
	 * @return string
	 */
	public function __call($name, $arguments) {
		$class = "FryHelper" . ucfirst($name);
		$dir = null;
		
		// find user helpers directory
		if (is_object($this->config) && $this->config->get('userHelpersDir')) {
			$dir = realpath($this->config->get('userHelpersDir'));
		}
 		
		// leave user the ability to override default helpers
		if ($dir && file_exists(
				$f = $dir . DIRECTORY_SEPARATOR . $class . '.php')) {
			
			// user helper
			$return = @include_once $f;
		} else {
			
			// default helper
			$return = @include_once $class . '.php';
		}

		if ($return && class_exists($class)) {
			$object = new $class($arguments);
			return $object->output();	
		}
		
		throw new FryNoCallableException('Can\'t load non existing helper: ' 
				. $class . ", arguments are: " . serialize($arguments));
	}
	
	/**
	 * Add template paths from config file to FryTemplate
	 * Should be called on FryTemplate setting to Fry
	 *
	 * @param FryTemplate $t
	 */
	private function addTemplatePaths(FryTemplate $t) {
		if (!is_null($this->config)) {
			
			$paths = $this->config->get('templatePaths');
			
			if (!isset($paths['path'])) {
				return;
			}
			
			if (count($paths['path']) == 1) {
				$t->addPath($paths['path']);				
			} elseif (is_array($paths['path'])) {
				foreach ($paths['path'] as $path) {
					$t->addPath($path);
				}
			}
		}
	}
	
	/**
	 * Setter for config
	 *
	 * @param FryConfig $config
	 */
	public function setConfig(FryConfig $config) {
		$this->config = $config;
	}
	
	/**
	 * Getter for config
	 *
	 * @return FryConfig
	 */
	public function getConfig() {
		return $this->config;
	}
	
	public function setDictionary(FryDictionary $dictionary) {
		$this->dictionary = $dictionary;
	}
	
	public function filter($var) {
		return FryFilterCaller::getInstance($var);
	}
	
	public function __toString() {
		return get_class($this);
	}
}

?>