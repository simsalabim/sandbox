<?php
/**
 * Class provides functionality to work with curl
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

class Curl {

  /**
   * User Agents array
   * @var array
   */
  private $userAgents = array (
    'FireFox3' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.9) Gecko/2008052906 Firefox/3.0',
    'GoogleBot' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
    'IE7' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)',
    'Netscape' => 'Mozilla/4.8 [en] (Windows NT 6.0; U)',
    'Opera' => 'Opera/9.25 (Windows NT 6.0; U; en)'
  );

  /**
   * Options array
   * @var array
   */
  private $options = array(
    CURLOPT_USERAGENT => '',
    CURLOPT_AUTOREFERER => true,
    CURLOPT_COOKIEFILE => '',
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_RETURNTRANSFER => false,
  );

  /**
   * Curl handler
   * @var resource
   */
  private $handler;


  /**
   * Create instance
   * @return void
   */
  public function __construct() {
    $this->setOption(CURLOPT_USERAGENT, $this->userAgents['FireFox3']);
  }


  /**
   * Set curl option
   *
   * @param  mixed $key option key in $this->options
   * @param  mixed $value value to set 
   * @return void
   */
  public function setOption($key, $value) {
    $this->options[$key] = $value;
  }

  public function get($url) {
    $this->handler = curl_init($url);
    $this->setOption(CURLOPT_HTTPGET, true);
    $this->setOption(CURLOPT_RETURNTRANSFER, true);
    curl_setopt_array($this->handler, $this->options);
    $result = curl_exec($this->handler);
    if (! $result) {
      throw new Exception('Noting got for ' . $url);
    }
    return $result;
  }

  public function getUserAgents() {
    return $this->userAgents;
  }


  /**
  * Build query string from array
  *
  * @param array $params source array
  * @return string
  */
  static public function buildParams($params = array()) {
    if (is_null($params)) {
      return '';
    }
    $result = '?';
    foreach($params as $key => $value) {
      if (is_array($value)) {
        $result .= self::buildGetArray($key, $value);
      } else {
        $result .= $key . '=' . $value . '&';
      }
    }
    return $result;
  }


  /**
   * Transform multidimentional array into query string
   *
   * @param string $name array name in resulting query string
   * @param array $array source array
   * @return string
   */
  static public function buildGetArray($name, $array) {
    static $result;
    static $node;
    foreach($array as $key => $value) {
      $node[] = $key;
      if (is_array($value)) {
        $result .= self::buildGetArray($name, $value);
      } else {
        $result .= $name . self::squareBrace($node) . '=' . $value . '&';
        array_pop($node);
      }
    }
    $node = array();
    $returning = $result;
    $result = '';
    return $returning;
  }

  /**
   * Wrap values of source multidimentional array with square braces '[]', required for query string building
   *
   * @param array $array source array
   * @return string array-member variable name in query string
   */
  static public function squareBrace($array) {
    $result= '';
    foreach ($array as $value) {
      $result .= '[' . $value . ']';
    }
    return $result;
  }


}
