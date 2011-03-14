<?php
/**
 * Base Controller class.
 * All application controllers should extend it and just implement their actions.
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

class Controller {

  /**
   * Route information
   * @var array
   */
  protected $route;

  /**
   * Layout adapter
   * @var object
   */
  protected $layout;

  /**
   * Path to layout
   * @var string
   */
  protected $layoutPath;

  /**
   * Temlate adapter
   * @var object
   */  
  protected $template;

  /**
   * Path to temlate
   * @var string
   */  
  protected $templatePath;


  /**
   * Create controller instance, sets route, default layout and template
   *
   * @param array $route [optional]
   * @return void
   */
  public function __construct($route = array()) {
    $route = empty($route) ? Application::$route : $route;
    $this->route = $route;
    $this->setTemplate($route['controller'] . '/' . $route['action']);
    $this->setLayout('layout');
  }


  /**
   * Set controller's template
   *
   * @param string $tplPath path to template
   * @return void
   */
  protected function setTemplate($tplPath) {
    $variables = $this->template ? $this->template->getVariables() : array();
    $this->template = new Template($tplPath);
    $this->template->assign($variables);
    $this->templatePath = $tplPath . '.' . $this->template->getExtension();
  }


  /**
   * Set controller's layout
   *
   * @param string $layoutPath path to layout
   * @return void
   */
  protected function setLayout($layoutPath) {
    $this->layout = new Template($layoutPath);
    $this->layoutPath = $layoutPath . '.' . $this->template->getExtension();
  }

  
  /**
   * Assign variables to controller's template.
   * If $variables is an array and $value == null assign variables with names of array keys and values of array values.
   * Else assign single variable named by $variables and gives it value of $value
   *
   * @param mixed|array $variables 
   * @param mixed $value [null]
   * @return void
   */  
  protected function assign($variables, $value = null) {
    $this->template->assign($variables, $value);
  }


  /**
   * Remove controller's layout
   *
   * @return void
   */  
  protected function releaseLayout() {
    $this->layout = null;
    $this->layoutPath = null;
  }


  /**
   * Render template and layout if exist.
   *
   * @return void
   */  
  protected function render($tplPath = null) {
    $tplPath = is_null($tplPath) ? $this->templatePath : $tplPath;
    $body = $this->template->fetch($tplPath);
    if ($this->layout) {
      $this->layout->assign('BODY', $body);
      $this->layout->render();
    } else {
      echo $body;
    }
  }

  
  /**
   * Check if action was requesed by POST
   *
   * @return void
   */ 
  protected function isPost() {
    return strtolower($this->route['method']) == 'post';
  }


}
