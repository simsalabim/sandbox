<?php
/**
 * Class provides functionality to work with arrays
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */
class Utils_Array {

 /**
  * Get first element of array or its key if $return_key
  *
  * @param array $array source array
  * @param boolean $return_key [false]
  * @return mixed
  */
  public static function first($array, $return_key = false) {
    foreach ($array as $key => $element)
      return ($return_key ? $key : $array[$key]);
  }


 /**
  * Get last element of array or its key if $return_key
  *
  * @param array $array source array
  * @param boolean $return_key [false]
  * @return mixed 
  */
  public static function last($array, $return_key = false) {
    $counter = 1;
    foreach ($array as $key => $element) {
      if ($counter == count($array))
        return ($return_key ? $key : $element);
      $counter++;
    }
  }


 /**
  * Get element from hash by index
  *
  * @param array $array source array
  * @param String || Integer $index
  * @param mixed $returning
  * @return mixed
  */
  public static function get($array, $index, $returning = false) {
    if (isset($array[$index]) && !empty($array[$index]))
      return $array[$index];
    return $returning;
  }


  /**
   * Swap array's keys and values
   *
   * @param array $array source array
   * @return array
   */
  public static function swap($array) {
    return array_combine(array_values($array), array_keys($array));
  }


  /**
   * парсит http query в массив и помещается в 1 строке
   * @param string $httpQuery
   * @return array
   */
  public static function fromHttpQuery($httpQuery) {
    if (is_string($httpQuery)) {
      parse_str($httpQuery, $array);
      return $array;
    }
    return array();
  }
}
