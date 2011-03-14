<?php
/**
 * Abstract template adapter class.
 * Provides common basic templates [adapters] functionality. All templates functionality depends on this.
 *
 * @abstract
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */


abstract class Adapters_Template {

  abstract public function __construct();

  
  /**
   * Get template extension.
   *
   * @return string
   */
  abstract public function getExtension();

  
  /**
   * Set templates directory
   *
   * @param string $dir path to directory
   * @return void
   */
  abstract public function setTemplateDir($dir);


  /**
   * Assign variables to template
   * If $variables is an array and $value == null assign variables with names of array keys and values of array values
   * Else assign single variable named by $variables and gives it value of $value
   *
   * @param mixed|array $variables 
   * @param mixed $value [null]
   * @return void
   */
  abstract public function assign($variables, $value = null);


  /**
   * Fetch template and return it as string without display
   *
   * @param string $tplPath path to template
   * @return string fetched template
   */
  abstract public function fetch($tplPath);


  /**
   * Display fetched template
   *
   * @param string $tplPath path to template
   * @return void
   */
  abstract public function render($tplPath);


}
