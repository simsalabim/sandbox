<?php
/**
 * Crawler class to snatch and parse info from BN
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

class Bn_Crawler extends Crawler {

  protected $url = 'http://www.bn.ru/zap_fl.phtml';

  protected $paginator = array(
    'param' => 'start',
    'lastNode' => array (
      array('find' => 'table td[align=right] a:last'),
      array('attr' => 'href'),
    )
  );

  protected $itemsPath = array(
    'container' => array(
      array('find' => 'table.results tr[class!=ban]:has(td)'),
    ),
    'pieces' => array(
      array('find' => 'td')
    )
  );

  /**
   * Metro data storage file
   */
  private $metroCache = 'metro.dat';


  /**
   * Constructor
   * @return void
   */
  public function __construct() {
    parent::__construct();
    $this->getMetro();
  }


  /**
   * Make transformations with crawler results page parts
   *
   * @static
   * @param  int $i iteration number
   * @param  DOMElement $v
   * @param  string $piecesPath
   * @return void
   */
  static public function callbackItemsContainer($i, $v, $piecesPath) {
    $document = pq($v);
    self::$callbackResultHelper[$i]['container'] = $document->html();

    foreach ($piecesPath as $traverse) {
      foreach($traverse as $method => $arg) {
        $pieces = $document->$method($arg);
      }
    }
    phpQuery::each($pieces, array(__CLASS__, 'callbackItemsPieces'), new CallbackParam, new CallbackParam, $i);
  }


  /**
   * Make transformations with crawler results page sub-parts
   *
   * @static
   * @param  int $i iteration number
   * @param  DOMElement $v
   * @param  int $containerIndex
   * @return void
   */
  static public function callbackItemsPieces($i, $v, $containerIndex) {
    $document = pq($v);
    self::$callbackResultHelper[$containerIndex]['pieces'][] = $document->html();
  }


  /**
   * Get array of metro station with indexes (for query building)
   *
   * @return array (id => station)
   */
  public function getMetro() {
    $metroCache = Application::getConfig()->paths->app->cache() . '/' . $this->metroCache;
    if (file_exists($metroCache)) {
      return json_decode(file_get_contents($metroCache));
    }
    $content = $this->snatch('http://www.bn.ru/zap_fl_w2.phtml');
    phpQuery::newDocumentHTML($content, 'utf-8');
    $document = pq('');
    $metro = $document->find('#metro option');

    self::$callbackResultHelper = array();
    phpQuery::each($metro, array(__CLASS__, 'callbackMetro'), new CallbackParam, new CallbackParam);

    $data = json_encode(self::$callbackResultHelper);
    file_put_contents($metroCache, $data);
    self::$callbackResultHelper = array();
    return $data;
  }

  /**
   * Put metro information (id, station name) to callbackHelper
   *
   * @static
   * @param  int $i iteration number
   * @param  DOMElement $v
   * @return void
   */
  static public function callbackMetro($i, $v) {
    $document = pq($v);
    self::$callbackResultHelper[$document->attr('value')] = $document->html();
  }

}
