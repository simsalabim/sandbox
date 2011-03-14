<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 19.02.11
 * Time: 23:00
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

namespace Core\Utils;

class Inflector {

  public static function underscore($camelCasedWord) {
    return strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $camelCasedWord));
  }

  public static function humanize($lowerCaseAndUnderscoredWord) {
    return ucwords(str_replace('_', ' ', $lowerCaseAndUnderscoredWord));
  }

  public static function camelize($word) {
    $camelized = str_replace(array(' ', '_', '-'), '', ucwords($word));
    return strtolower($camelized[0]) . substr($camelized, 1);
  }

}
