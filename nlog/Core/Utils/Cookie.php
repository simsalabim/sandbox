<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 17.02.11
 * Time: 21:26
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

namespace Core\Utils;

class Cookie {

  protected $name;
  protected $value;
  protected $expire = 0;
  protected $path;
  protected $domain;
  protected $secure = false;
  protected $httponly = false;

  public function __construct($params = array()) {
    $this->setParams($params);
  }

  /**
   * Установка параметров куки
   * @param array $params ассоциативный массив с параметрами вида ('name' => 'LWH', 'value' => 'join The Dark Side')
   * @return void
   */
  public function setParams(array $params) {
    $this->name = ArrayFu::get($params, 'name', $this->name);
    $this->value = ArrayFu::get($params, 'value', $this->value);
    $this->expire = ArrayFu::get($params, 'expire', $this->expire);
    $this->path = ArrayFu::get($params, 'path', $this->path);
    $this->domain = ArrayFu::get($params, 'domain', $this->domain);
    $this->secure = ArrayFu::get($params, 'secure', $this->secure);
    $this->httponly = ArrayFu::get($params, 'httponly', $this->httponly);
  }


  /**
   * Установка куки в браузере
   * @return bool
   */
  public function set() {
    return setcookie($this->name, $this->value, $this->expire, $this->path, $this->domain, $this->secure, $this->httponly);
  }

  /**
   * Получить значение куки с заданным именем
   * @param string $name имя куки
   * @return string
   */
  public function get($name) {
    return ArrayFu::get($_COOKIE, $name, null);
  }


  /**
   * Проверка на существование куки с заданным именем
   * @param string $name имя куки
   * @return bool
   */
  public function exists($name) {
    return in_array($name, array_keys($_COOKIE));
  }


  /**
   * Динамические сеттеры и геттеры (выполняются при отсутствии прямых определений getFeild()/ setField())
   * get<Field>()
   * set<Field>($value)
   */
  public function __call($method, $args) {
    if(! preg_match('/(set|get)(.+)/', $method, $matches)){
      return;
    }
    $methodType = $matches[1];
    $paramName = strtolower(substr($matches[2], 0, 1)) . substr($matches[2], 1);

    if (! in_array($method, get_class_methods(get_class($this))) && property_exists(get_class($this), $paramName)) {
      switch ($methodType) {
        case 'set':
          return $this->setParam($paramName, $args[0]);
        case 'get':
          return $this->getParam($paramName);
      }
    }
  }


  /**
   * Возвращает значение поля $field
   * @param string $field название поля
   * @return mixed значение
   */
  public function getParam($field) {
    return $this->$field;
  }

  /**
   * Устанавливает значение поля $field
   * @param string $field название поля
   * @param mixed $value значение поля
   * @return mixed значение
   */
  public function setParam($field, $value) {
    return $this->$field = $value;
  }

}