<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 17.02.11
 * Time: 22:19
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

namespace App\Controllers;

use \Core\Utils\Debug as Debug;
use \App\Helpers\Auth as Auth;
use \App\Models\Post as Post;
use \App\Models\Comment as Comment;
use \App\Models\User as User;

class Posts extends \Core\Controller {

  protected $userRecord;

  protected $postRecord;

  protected $commentRecord;

  protected $user;


  public function __construct() {
    parent::__construct();
    $this->userRecord = new User();
    $this->postRecord = new Post();
    $this->commentRecord = new Comment();
    $this->user = Auth::instance()->getUser();
    $this->assign('user', $this->user);
  }

  
  /**
   * Покажем список постов с комментариями
   * 
   * @return void
   */
  public function index() {
    $posts = $this->postRecord->find(array('orderBy' => '`created_at` DESC'));
    $this->assign('posts', $posts);
  }


  /**
   * Показать пост с его комментариями
   *
   * @return void
   */
  public function show() {
    $params = $this->getParams();
    $post = $this->postRecord->get($params['id']);
    $user = $this->userRecord->get($post['user_id']);
    $comments = $this->commentRecord->find(array(
      'commentable_id' => $post['id'],
      'commentable_type' => 'posts',
      'orderBy' => '`created_at` ASC'
    ));
    $this->assign(array('post' => $post, 'comments' => $comments, 'user' => $user));
  }


  public function create() {
    if (! in_array('editor', $this->user['roles'])) {
      $this->accessDenied();
      return;
    }
    if ($this->isPost()) {
      $postParams = $this->getPostParams();
      $this->postRecord->create($postParams);
      $this->redirect('/posts');
    }
  }


  
}
