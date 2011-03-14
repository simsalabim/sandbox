<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 20.02.11
 * Time: 18:37
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */
 
namespace App\Models;

use \Core\Utils\Debug as Debug;
use \Core\Utils\ArrayFu as ArrayFu;
use \App\Models\UserRole as UserRole;
  
class User extends \Core\ActiveRecord {

  public function __construct() {
    parent::__construct();
    $this->tableName = 'users';
    $this->usersRolesRecord = new UserRole();
  }

  public function find($conditions = array()) {
    $users = parent::find($conditions);
    foreach ($users as $key => $user) {
      $userRoles = $this->usersRolesRecord->find(array('user_id' => $user['id']));
      $users[$key]['roles'] = ArrayFu::getSubArray($userRoles, 'role');
    }
    return $users;
  }

}