<?php
/**
 * Config class.
 * Access to config properties (chainlike dot-separated):
 *
 * <code>
 * // get value placed at $config['paths']['app']['views']
 *
 * Application::getConfig('paths.app.views');
 *
 * @deprecated
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
   * @deprecated
   * @var array
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
   * Get value from config by its path (dot-separated), $config->get('path.to.node.value')
   * @param  string $path
   * @return array|mixed|source
   */
  public function get($path) {
    $path = explode('.', $path);
    $currentNode = $this->data;
    foreach ($path as $node) {
      $currentNode = Utils_Array::get($currentNode, $node);
    }
    return $currentNode;
  }


  /**
   * Get intermediate livel nodes of config
   * @deprecated new style to access config value is in use: $c->get('path.to.node') instead of $c->path->to->node()
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
   * @deprecated new style to access config value is in use: $c->get('path.to.node') instead of $c->path->to->node()
   *
   * @param  string $method node name
   * @param  array $args arguments. Default value that will be returned in case of
   * node with name $method doesn't exists or empty
   * @return string
   */
  public function __call($method, $args) {
    $value = Utils_Array::get($this->currentNode, $method, Utils_Array::get($args, 0));
    $this->currentNode = $this->data;
    return $value;
  }


}
