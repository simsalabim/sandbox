<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 20.02.11
 * Time: 23:48
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

namespace App\Models;

class UserRole extends \Core\ActiveRecord {

  public function __construct() {
    parent::__construct();
    $this->tableName = 'users_roles';
  }

}
