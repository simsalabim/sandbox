<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 20.02.11
 * Time: 11:41
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

namespace App\Models;

use \App\Models\User as User;
use \App\Helpers\Auth as Auth;
  
class Comment  extends \Core\ActiveRecord {

  protected $userRecord;

  public function __construct() {
    parent::__construct();
    $this->tableName = 'comments';
    $this->userRecord = new User();
  }

  public function create($data) {
    $user = Auth::instance()->getUser();
    $data['id'] = 'NULL';
    $data['user_id'] = $user['id'];
    $data['created_at'] = date('Y-m-d H:i:s');
    $data['updated_at'] = $data['created_at'];
    $data['deleted_at'] = 'NULL';
    $this->save($data);
  }

  public function find($conditions = array()) {
    $comments = parent::find($conditions);
    foreach ($comments as $key => $comment) {
      $comments[$key]['user'] = $this->userRecord->get($comment['user_id']);
    }
    return $comments;
  }

}
