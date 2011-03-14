<?php
/**
 * Index controller
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com> 
 */
class IndexController extends Controller {


  /**
   * Display search form and search result, if posted
   *
   * @return void
   */
  public function indexAction() {
    $this->assign(array(
      'params' => $this->route['post'],
    ));
    $this->render();
  }


}