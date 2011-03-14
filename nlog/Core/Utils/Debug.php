<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 17.02.11
 * Time: 22:04
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

namespace Core\Utils;


class Debug {
   /**
    * Show any variable in html
    *
    * @param mixed $variable
    * @param string $backtrace
    */
    public static function show($variable, $backtrace = null){
      $backtrace = ArrayFu::first(empty($backtrace) ? debug_backtrace() : $backtrace);
      print '<strong>' . $backtrace['file'] . '</strong>&nbsp;(line <strong>' . $backtrace['line'] . '</strong>)';
      print '<pre>';
      var_dump($variable);
      print '</pre>';
    }
}
