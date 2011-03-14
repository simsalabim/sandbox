<?php
/**
 * Debugging methods
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */
class Utils_Debug {

   /**
    * Show any variable in html
    *
    * @param mixed $variable
    * @param string $backtrace
    */
    public static function show($variable, $backtrace = null){
      $backtrace = Utils_Array::first(empty($backtrace) ? debug_backtrace() : $backtrace);
      print '<strong>' . $backtrace['file'] . '</strong>&nbsp;(line <strong>' . $backtrace['line'] . '</strong>)';
      print '<pre>';
      var_dump($variable);
      print '</pre>';
    }
 }
