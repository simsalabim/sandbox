<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 19.02.11
 * Time: 16:26
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

namespace App\Models;

use \App\Models\Comment as Comment;
use \App\Models\User as User;
use \App\Helpers\Auth as Auth;

class Post extends \Core\ActiveRecord {

  protected $userRecord;

  protected $commentRecord;

  
  public function __construct() {
    parent::__construct();
    $this->tableName = 'posts';
    $this->userRecord = new User();
    $this->commentRecord = new Comment();
  }

  /**
   * Найти все посты по заданным критериям и связанные с ними комментарии и пользователей (авторов)
   *
   * @param array $conditions
   * @return array
   */
  public function find($conditions = array()) {
    $posts = parent::find($conditions);
    foreach ($posts as $key => $post) {
      $posts[$key]['comments'] = $this->commentRecord->find(array('commentable_id' => $post['id'], 'commentable_type' => 'posts'));
      $posts[$key]['user'] = $this->userRecord->get($post['user_id']);
    }
    return $posts;
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

}
