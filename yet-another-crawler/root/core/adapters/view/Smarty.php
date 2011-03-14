<?php
/**
 * Smarty templates adapter.
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

class Adapters_View_Smarty extends Adapters_Template {

  private $engine;

  public function __construct() {
    Application::load3rdParty('Smarty/libs/Smarty.class.php');
    $this->engine = new Smarty;
  }


  public function getExtension() {
    return 'tpl';
  }


  public function setTemplateDir($dir) {
    $this->engine->setTemplateDir($dir);
  }


  public function assign($variables, $value = null) {
    $this->engine->assign($variables, $value);
  }


  public function fetch($tplPath) {
    return $this->engine->fetch($tplPath);
  }


  public function render($tplPath) {
    return $this->engine->display($tplPath);
  }


}
