<?php
/**
 * Config class.
 * Access to config properties (chainlike):
 *
 * <code>
 * // get value placed at $config['paths']['app']['views']
 *
 * Application::getConfig()->paths->app->views();
 * </code>
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

class Config {

  /**
   * Parsed config data storage
   * @var array
   */
  private $data;

  /**
   * Current selected node storage
   *  @var array
   */
  private $currentNode;

  
  /**
   * Create new config instance
   *
   * @param  $array source config data
   * @return Config
   */
  public function __construct(array $array) {
    $this->data = $array;
    $this->currentNode = $this->data;
    return $this;
  }


  /**
   * Get intermediate livel nodes of config
   *
   * @param  $key node name
   * @return Config
   */
  public function __get($key) {
    $this->currentNode = Utils_Array::get($this->currentNode, $key, array());
    return $this;
  }


  /**
   * Get target livel node of config
   *
   * @param  $key node name
   * @return string
   */
  public function __call($method, $args) {
    $value = Utils_Array::get($this->currentNode, $method);
    $this->currentNode = $this->data;
    return $value;
  }


}
