<?php
/**
 * Abstract crawler class to snatch content and parse typical 'results pages' with multiple similar items
 * @abstract
 * @dependencies phpQuery
 * @see implementation app/libs/bn/Crawler.php
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

abstract class Crawler {

  /**
   * Default crawler page encoding [utf-8]
   * @var string
   */
  protected $encoding = 'utf-8';

  /**
   * Crawler target url
   * @var string
   */
  protected $url;

  /**
   * Query params
   * @var array
   */
  protected $params = array();

  /**
   * Array contains info about paginator node path (phpQuery selector) in results page and its get-param name
   * @var
   */
  protected $paginator = array(
    'param' => '',
    'lastNode' => array (
      array('find' => 'a:last'),
      array('attr' => 'href'),
    )
  );

  /**
   * Array contains node paths (phpQuery selectors) to items container and container's parts
   * @var array
   */
  protected $itemsPath = array(
    'container' => array(
      array('find' => 'table:first tr'),
    ),
    'pieces' => array(
      array('find' => 'td'),
    )
  );

  protected $exploration = array();

  /**
   * Snatched content storage
   * @var string
   */
  protected $content;

  /**
   * Curl adapter
   * @var object
   */
  private $curl;

  /**
   * Intermediate storage of callbacks results
   * @staticvar array
   */
  static $callbackResultHelper = array();


  /**
   * Creqte crawler instance
   *
   * @param array $params [optional] query params
   * @return void
   */
  public function __construct($params = array()) {
    Application::load3rdParty('phpQuery/phpQuery-onefile.php');
    $this->params = array_merge($this->params, $params);
    $this->curl = new Curl();
  }


  /**
   * Snatch content from target url
   *
   * @param  string $url target url
   * @param array $params [optional] additional query params
   * @return string snathed content
   */
  public function snatch($url, $params = array()) {
    $params = array_merge($this->params, $params);
    $this->content = $this->curl->get($this->buildUrl($url, $params));
    return $this->content;
  }


  /**
   * Get exploration of
   *
   * @param array $params [optional] additional query params
   * @return array('pagesCount' => .., 'items' => array(array('container' => .., 'pieces' => array(..,)), ...))
   */
  public function explore($params = array()) {
    $this->content = $this->snatch($this->url, $params);
    $this->countPages();
    $this->parseItems();
    return $this->exploration;
  }


  /**
   * Get crawler's content
   *
   * @return string
   */
  public function getContent() {
    return $this->content;
  }


  /**
   * Get pages count
   *
   * @return int
   */
  public  function countPages() {
    phpQuery::newDocumentHTML($this->content, $this->encoding);
    $document = pq('');
    foreach ($this->paginator['lastNode'] as $traverse) {
      foreach($traverse as $method => $arg) {
        $document = $document->$method($arg);
      }
    }
    preg_match('#.*' . $this->paginator['param'] . '=(\d+).*#', $document, $pagesCount);
    $this->exploration['pagesCount'] = $pagesCount[1];
    return $this->exploration['pagesCount']; 
  }


  /**
   * Parse crawler content by items 
   *
   * @return array (array('container' => .., 'pieces' => array(..,)), ..)
   */
  public function parseItems() {
    phpQuery::newDocumentHTML($this->content, $this->encoding);
    $items = array();
    $document = pq('');
    foreach ($this->itemsPath['container'] as $traverse) {
      foreach($traverse as $method => $arg) {
        $document = $document->$method($arg);
      }
    }
    phpQuery::each($document, array(get_class($this), 'callbackItemsContainer'), new CallbackParam, new CallbackParam, $this->itemsPath['pieces']);
    $this->exploration['items'] = self::$callbackResultHelper;
    return $this->exploration['items'];
  }


 /**
  * Build crawler target url with query params
  *
  * @param  string $url target url
  * @param array $params [optional] query params
  * @return string
  */
  protected function buildUrl($url, $params = array()) {
    $url = parse_url($url);
    //$query = $params ? http_build_query($params) : ''; incorrect query string is formed
    $query = $params ? Curl::buildParams($params) : '';
    $query = isset($url['query']) ? $url['query'] . $query : $query;
    return $url['scheme'] . '://' . $url['host'] . $url['path'] . '?' . $query;
  }


  /**
   * Make transformations with crawler results page parts
   *
   * @static
   * @abstract
   * @param  int $i iteration number
   * @param  DOMElement $v
   * @param  string $piecesPath node path to container's parts
   * @return void
   */
  abstract static public function callbackItemsContainer($i, $v, $piecesPath);
  

  /**
   * Make transformations with crawler results page sub-parts
   *
   * @static
   * @abstract
   * @param  int $i iteration number
   * @param  DOMElement $v
   * @param  int $containerIndex sub-part container index
   * @return void
   */
  abstract static public function callbackItemsPieces($i, $v, $containerIndex);


}
