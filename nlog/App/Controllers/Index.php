<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 17.02.11
 * Time: 21:53
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

namespace App\Controllers;

use \Core\Utils\Debug as Debug;
use \Core\Utils\Cookie as Cookie;
use \App\Helpers\Auth as Auth;
use \App\Models\User as User;


class Index extends \Core\Controller {

  protected $userRecord;

  protected $cookie;

  public function __construct() {
    parent::__construct();
    $this->userRecord = new User();
    $this->cookie = new Cookie;
  }

  public function index() {
    Auth::instance()->getUser();

    if ($this->isPost()) {
      $postParams = $this->getPostParams();
      $user = $this->userRecord->find(array('login' => $postParams['login'], 'password' => md5($postParams['password'])));
      if ($user) {
        $this->cookie->setParams(array('name' => 'LWH', 'value' => sha1($user['password'] . $user['created_at'])));
        $this->cookie->set();
        $this->redirect('/posts');
      } else {

        $this->assign('error', 'Invalid login/password pair');
      }
    }
  }

  public function logout() {
    $this->setNoOutput();
    $this->cookie->setParams(array('name' => 'LWH', 'value' => 'asd', 'expire' => time() - 3600));
    $this->cookie->set();
    $this->redirect('/');
  }

  
}
