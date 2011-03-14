<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 17.02.11
 * Time: 22:23
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

namespace Core;

use \Core\Utils\Debug as Debug;

  
class Template {

  /**
   * Template extension
   * @var string
   */
  private $extension = 'template';

  /**
   * Template vars in array formant (var_name => value)
   * @var array
   */
  private $variables = array();

  /**
   * Path to template
   * @var string
   */
  private $templatePath;


  /**
   * Create new template instance
   *
   * @param string $filePath path to template
   * @return void
   */
  public function __construct($filePath) {
    $this->templatePath = $filePath . '.' . $this->extension;
  }


  /**
   * Get template extension.
   *
   * @return string
   */
  public function getExtension() {
    return $this->extension;
  }


  /**
   * Assign variables to template
   * If $variables is an array and $value == null assign variables with names of array keys and values of array values
   * Else assign single variable named by $variables and gives it value of $value
   *
   * @param mixed|array $variables
   * @param mixed $value [null]
   * @return void
   */
  public function assign($variables, $value = null) {
    if (is_array($variables)) {
      $this->variables = array_merge($this->variables, $variables);
    } else {
      $this->variables[$variables] = $value;
    }
  }


  /**
   * Fetch template and return it as string without display
   *
   * @param string $tplPath [null] path to template
   * @return string fetched template
   */
  public function fetch($tplPath = null) {
    $tplPath = is_null($tplPath) ? $this->templatePath : $tplPath;

    foreach ($this->variables as $name => $value) {
      eval('$' . $name . '= $value;');
    }

    ob_clean();
    ob_start();
    require_once('../App/Views/' . $tplPath);
    $buf = ob_get_contents();
    ob_end_clean();

    return $buf;
  }


  /**
   * Display fetched template
   *
   * @param string $tplPath [null] path to template
   * @return void
   */
  public function render($tplPath = null) {
    $tplPath = is_null($tplPath) ? $this->templatePath : $tplPath;
    $fetched = $this->fetch($tplPath);
    echo $fetched;
  }


}
