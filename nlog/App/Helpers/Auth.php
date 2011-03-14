<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 20.02.11
 * Time: 23:28
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */
namespace App\Helpers;

use \App\Models\User as User;
use \Core\Utils\Cookie as Cookie;
use \Core\Utils\Debug as Debug;
use \Core\Utils\ArrayFu as ArrayFu;

class Auth {

  protected static $vector = null;

  protected $user;

  protected function __clone() {
  }

  public static function instance() {
    return (self::$vector ? self::$vector : (self::$vector = new self()));
  }

  public function getUser() {
    $cookie = new Cookie();
    $userRecord = new User;
    $guest = $userRecord->get(1);

    if (! $cookie->exists('LWH')) {
      $cookie->setParams(array('name' => 'LWH', 'value' => sha1($guest['password'] . $guest['created_at'])));
      $cookie->set();
    }

    $salt = $cookie->get('LWH');
    $user = $userRecord->find(array('salt' => $salt, 'limit' => 1));
    $this->user = ArrayFu::first($user);
    return $this->user;
  }
}
