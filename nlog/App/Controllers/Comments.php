<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 20.02.11
 * Time: 12:12
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

namespace App\Controllers;

use \Core\Utils\Debug as Debug;
use \App\Models\Post as Post;
use \App\Models\Comment as Comment;

class Comments  extends \Core\Controller {

  public function create() {
    $this->setNoOutput();
    $postParams = $this->getPostParams();
    $commentRecord = new Comment();
    $commentRecord->create($postParams);
    $this->redirect($_SERVER['HTTP_REFERER']);
  }

}
