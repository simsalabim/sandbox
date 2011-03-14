<?php
/**
 * Index controller
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com> 
 */
class IndexController extends Controller {

  /**
   * Search filters adapter
   * @var object
   */
  protected $filters;

  /**
   * Crawler adapter
   * @var object
   */
  protected $crawler;


  /**
   * Constructor
   * @return void
   */
  public function __construct() {
    parent::__construct();
    $this->filters = new Bn_Filters();
    $this->crawler = new Bn_Crawler();
  }


  /**
   * Display search form and search result, if posted
   *
   * @return void
   */
  public function indexAction() {
    if ($this->isPost()) {
      $this->assign('advertisements', $this->getAdvertisements());
    }
    $this->assign(array(
      'params' => $this->route['post'],
      'metro' =>  $this->crawler->getMetro()
    ));
    $this->render();
  }


  /**
   * Render search results partial
   *
   * @return void
   */
  public function searchAction() {
    $this->assign(array(
      'advertisements' => $this->getAdvertisements(),
    ));
    $this->setTemplate('index/_search');
    $this->releaseLayout();
    $this->render();
  }


  /**
   * Get advertisements list
   *
   * @return array
   */
  public function getAdvertisements() {
    $params = $this->route['post'];
    $items = $this->crawler->explore($this->filters->process($params));
    $advertisement = new Bn_Advertisement();
    $advertisements = $advertisement->buildList($this->crawler->getContent(), $items['items']);
    return $advertisements;
  }





}