<?php
/**
 * Class provides functionality to work with BN advertisements
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

class Bn_Advertisement {

  /**
   * Build advertisements list collection
   *
   * @param  string $content html-content of results page
   * @param  array $params
   * @return array
   */
  public function buildList($content, array $params) {
    Application::load3rdParty('phpQuery/phpQuery-onefile.php');
    foreach ($params as $key => $item) {
      phpQuery::newDocumentHTML($item['container'], 'utf-8');
      $document = pq($item['pieces'][1]);
      $list[$key]['edition'] = $document->html();
      $list[$key]['rooms'] = $item['pieces'][2];
      $document = pq($item['pieces'][3]);
      $list[$key]['address'] = $document->html();
      $list[$key]['metro'] = $item['pieces'][4];
      $list[$key]['floor'] = $item['pieces'][5];
      $document = pq($item['pieces'][6]);
      $list[$key]['type'] = $document->html();
      $list[$key]['square']['common'] = $item['pieces'][7];
      $list[$key]['square']['habitant'] = $item['pieces'][8];
      $list[$key]['square']['kitchen'] = $item['pieces'][9];
      $list[$key]['phone'] = $item['pieces'][10];
      $list[$key]['bathroom'] = $item['pieces'][11];
      $list[$key]['subject'] = $item['pieces'][15];
      $list[$key]['contact'] = $item['pieces'][16];
      $list[$key]['additional'] = $item['pieces'][17];
    }

    return $list;
  }

}
