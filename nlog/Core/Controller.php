<?php
/**
 * Created by JetBrains PhpStorm.
 * User: simsalabim
 * Date: 17.02.11
 * Time: 21:49
 * 
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

namespace Core;

use \Core\Utils\Debug as Debug;

class Controller {

  /**
   * Информация о роуте
   * @var array
   */
  protected $route;

  /**
   * Адаптер лэйаута
   * @var object
   */
  protected $layout;

  /**
   * Путь к лэйауту
   * @var string
   */
  protected $layoutPath;

  /**
   * Адаптер шаблона
   * @var object
   */
  protected $template;

  /**
   * Путь к шаблону
   * @var string
   */
  protected $templatePath;


  /**
   * Создаёт объект контроллера, устанавливает роут, шаблон и лэйаут по умолчанию
   *
   * @param array $route [optional]
   * @return void
   */
  public function __construct($route = array()) {
    $route = empty($route) ? Application::$route : $route;
    $this->route = $route;
    $this->setTemplate($route['controller'] . '/' . $route['action']);
    $this->setLayout('layout');
  }

  /**
   * По умолчанию методы контроллера рендерим
   */
  public function __destruct() {
    $this->render();
  }

  /**
   * Получить массив гет-параметров экшена
   * @return array
   */
  public function getParams() {
    return $this->route['params'];
  }

  /**
   * Получить массив пост-параметров экшена
   * @return array
   */
  public function getPostParams() {
    return $this->route['post'];
  }

  /**
   * Перенаправление по заданному пути
   *
   * @param string $path путь перенаправления
   * @return void
   */
  public function redirect($path) {
    header('Location: ' . $path);
  }


  public function accessDenied() {
    $this->setTemplate('accessDenied');
  }


  /**
   * Установить шаблон
   *
   * @param string $tplPath путь к шаблону
   * @return void
   */
  protected function setTemplate($tplPath) {
    $this->template = new Template($tplPath);
    $this->templatePath = $tplPath . '.' . $this->template->getExtension();
  }


  /**
   * Установить лэйаут
   *
   * @param string $layoutPath путь к лэйауту
   * @return void
   */
  protected function setLayout($layoutPath) {
    $this->layout = new Template($layoutPath);
    $this->layoutPath = $layoutPath . '.' . $this->template->getExtension();
  }


  /**
   * Assign variables to controller's template.
   * If $variables is an array and $value == null assign variables with names of array keys and values of array values.
   * Else assign single variable named by $variables and gives it value of $value
   *
   * @param mixed|array $variables
   * @param mixed $value [null]
   * @return void
   */
  protected function assign($variables, $value = null) {
    $this->template->assign($variables, $value);
  }


  /**
   * Указать, что лэйаута нет
   *
   * @return void
   */
  protected function setNoLayout() {
    $this->layout = null;
    $this->layoutPath = null;
  }


  /**
   * Указать, что шаблона нет
   *
   * @return void
   */
  protected function setNoTemplate() {
    $this->template = null;
    $this->templatePath = null;
  }


  /**
   * Указать, что метод ничего не выводит в std out
   *
   * @return void
   */
  protected function setNoOutput() {
    $this->setNoLayout();
    $this->setNoTemplate();
  }


  /**
   * Вывести результат рендеринга шаблона и лэйаута (если есть) в std out
   *
   * @return void
   */
  protected function render($tplPath = null) {
    if (! $this->template) {
      return;
    }
    
    $tplPath = is_null($tplPath) ? $this->templatePath : $tplPath;
    $body = $this->template->fetch($tplPath);

    if ($this->layout) {
      $this->layout->assign('BODY', $body);
      $this->layout->render();
    } else {
      echo $body;
    }
  }


  /**
   * Проверить, вызван ли экшн пост-запросом
   *
   * @return void
   */
  protected function isPost() {
    return strtolower($this->route['method']) == 'post';
  }

}
