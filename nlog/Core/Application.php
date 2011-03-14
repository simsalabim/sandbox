<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 17.02.11
 * Time: 21:51
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

namespace Core;

use \Core\Utils\ArrayFu as ArrayFu;
use \Core\Utils\Debug as Debug;
  
  
class Application {


  static $route;

  protected $controller;

  protected $action;

  protected $getParams;

  protected $postParams;

  static protected $config;


  /**
   * Create new application initialized via config passed in argument
   *
   * @param $config path to config file
   * @param $configParser path to config parser
   */
  public function __construct($configPath) {
    $config = json_decode(file_get_contents($configPath), true);
    self::$config = $config;
    mysql_connect($config['dbhost'], $config['dbuser'], $config['dbpass']) or die ('Error connecting to mysql');
    mysql_select_db($config['dbname']);
    $this->route();
  }


  /**
   * Main application method, calls controller action.
   *
   * Run, Forrest, run! (c)
   */
  public function run() {
    $controllerClass = "App\\Controllers\\" . self::$route['controller'];
    $controller = new $controllerClass(self::$route);
    $action = self::$route['action'];
    return $controller->$action();
  }



  /**
   * Get application config
   *
   * @static
   * @return array Application::$config
   */
  static public function getConfig() {
    return new Config(self::$config);
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

    $this->controller = ucfirst(ArrayFu::get($route, 1, 'index'));
    $this->action = ArrayFu::get($route, 2, 'index');

    self::$route = array(
      'controller' => $this->controller,
      'action' => $this->action,
      'params' => ArrayFu::fromHttpQuery($query),
      'post' => $this->postParams,
      'method' => $_SERVER['REQUEST_METHOD'],
    );
  }


}
