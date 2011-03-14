<?php
/**
 * Application class
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

class Application {

  const CONTROLLER_POSTFIX = 'Controller';

  const ACTION_POSTFIX = 'Action';

  static $route;

  protected $controller;

  protected $action;

  protected $actionParams;

  protected $getParams;

  protected $postParams;

  static protected $config;


  /**
   * Create new application initialized via config passed in argument
   *
   * @param $config path to config file
   * @param $configParser path to config parser
   */
  public function __construct($config, $configParser) {
    $this->autoload();
    $this->route();
    $this->setDebugMethod();
    $this->loadConfig($config, $configParser);
  }

  
  /**
   * Main application method, calls controller action.
   *
   * Run, Forrest, run! (c)
   */
  public function run() {
    $controllerName = ucfirst($this->controller) . self::CONTROLLER_POSTFIX;
    $actionName = ucfirst($this->action) . self::ACTION_POSTFIX;
    $controller = new $controllerName(self::$route);
    return $controller->$actionName();
  }


  /**
   * Load config and set include paths
   *
   * @param string $filename config filename
   * @param string $parser path to config parser
   * @return void
   */
  public function loadConfig($filename, $parser) {
    require_once($parser);
    self::$config = Spyc::YAMLLoad($filename);
    set_include_path(
      get_include_path() . PATH_SEPARATOR .
              getcwd() . PATH_SEPARATOR .
              realpath(self::getConfig('paths.app.controllers') . '/')
    );
    set_include_path(
      get_include_path() . PATH_SEPARATOR .
              getcwd() . PATH_SEPARATOR .
              realpath(self::getConfig('paths.app.libs') . '/')
    );
    set_include_path(
      get_include_path() . PATH_SEPARATOR .
              getcwd() . PATH_SEPARATOR .
              realpath(self::getConfig('paths.app.views') . '/')
    );
  }


  /**
   * Load 3rd Party source library
   *
   * @static
   * @param  string $filePath path to file from '/3rd-party/' directory
   * @return void
   */
  static public function load3rdParty($filePath) {
    require_once(Application::getConfig('paths.third_party') . '/' . $filePath);
  }


  /**
   * Get application config
   *
   * @static
   * @return array Application::$config
   */
  static public function getConfig($path = null) {
    $config = new Config(self::$config);
    return $path ? $config->get($path) : $config;
  }

 
  /**
   * Build route array from URI
   *
   * @return void
   */
  private function route() {
    $this->getParams = $_GET;
    $this->postParams = $_POST;

    $route = parse_url($_SERVER['REQUEST_URI']);
    $query = $route['query'];
    $route = explode('/', $route['path']);

    $this->controller = Utils_Array::get($route, 1, 'index');
    $this->action = Utils_Array::get($route, 2, 'index');

    self::$route = array(
      'controller' => $this->controller,
      'action' => $this->action,
      'params' => Utils_Array::fromHttpQuery($query),
      'post' => $this->postParams,
      'method' => $_SERVER['REQUEST_METHOD'],
    );
  }


  /**
   * Register autoload
   *
   * @return void
   */
  private function autoload() {
    spl_autoload_register(array($this, 'autoloadRules'));
  }
  

  /**
   * Autoload classes rules (not applied to 3rd Party directory)
   *
   * @param  string $className unloaded previously class name
   * @return string required filename
   */
  private function autoloadRules($className) {
    $backtrace = debug_backtrace();
    if (strpos($backtrace[1]['file'], '3rd-party')) {
      return;
    }
    $className = str_replace('_', '/', $className);
    $fileName = $className . '.php';
    require_once $fileName;
    return $fileName;
  }

  
  /**
   * Helper function for debugging
   */
  private function setDebugMethod() {
    if (! function_exists('debug')) {
      function debug($variable) {
        return Utils_Debug::show($variable, debug_backtrace());
      }
    }
  }



}
