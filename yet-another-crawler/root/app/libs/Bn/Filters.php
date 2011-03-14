<?php
/**
 * Class provides functionality to work with BN search filters
 *
 * @author Alexander Kaupanin <kaupanin@gmail.com>
 */

class Bn_Filters {

  /**
   * Search filters transformation map in array format of 'given name' => 'actual name'
   *
   * @var array
   */
  private $filters = array(
    'price_from' => 'prm1',
    'price_to' => 'prm2',
    'room_quantity_from' => 'kkv1',
    'room_quantity_to' => 'kkv2',
    'metro' => 'metro',
  );


  /**
   * Processes source filters array accordingly to transformations map
   *
   * @param  $data source array
   * @return array
   */
  public function process($data) {
    $processed = array();
    foreach($data as $key => $value) {
      if (in_array($key, array_keys($this->filters))) {
        $processed[$this->filters[$key]] = $value;
      }
    }
    return $processed;
  }

}
