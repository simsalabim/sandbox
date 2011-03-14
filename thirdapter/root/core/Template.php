<?php
/**
 * Template class.
 * Provides common basic templates functionality. Requires adapters and uses them as template engines.
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

class Template {

  /**
   * Template extension
   * @var string
   */
  private $extension;

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
   * Template adapter
   * @var object
   */
  private $adapter;


  /**
   * Create new template instance
   *
   * @param string $filePath path to template
   * @return void
   */
  public function __construct($filePath) {
    $this->loadAdapter();
    $this->templatePath = $filePath . '.' . $this->adapter->getExtension();
  }


  /**
   * Get template extension.
   *
   * @return string
   */
  public function getExtension() {
    return $this->adapter->getExtension();
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
    $this->adapter->assign($variables, $value);
  }


  /**
   * Fetch template and return it as string without display
   *
   * @param string $tplPath [null] path to template
   * @return string fetched template
   */
  public function fetch($tplPath = null) {
    $tplPath = is_null($tplPath) ? $this->templatePath : $tplPath;
    return $this->adapter->fetch($tplPath);
  }

  
  /**
   * Display fetched template
   *
   * @param string $tplPath [null] path to template
   * @return void
   */
  public function render($tplPath = null) {
    $tplPath = is_null($tplPath) ? $this->templatePath : $tplPath;
    return $this->adapter->render($tplPath);
  }
  
  
  /**
   * Get template variables
   *
   * @return array
   */ 
  public function getVariables() {
    return $this->variables;
  }

  
  /**
   * Load template adapter
   *
   * @return void
   */ 
  protected function loadAdapter() {
    $config = Application::getConfig();
    $adapterClass = ucfirst($config->get('paths.app.adapters.common')) . '_' . ucfirst($config->get('paths.app.adapters.templates')) . '_' . ucfirst($config->get('templates.adapter'));
    $this->adapter = new $adapterClass;
    $this->adapter->setTemplateDir($config->get('paths.app.views'));
  }


}
