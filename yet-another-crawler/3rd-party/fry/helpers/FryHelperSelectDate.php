<?php

/**
 * FryHelper for generation of select tags for date selection
 * 
 * @package Fry
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @version $Id: FryHelperSelectDate.php 14 2007-05-14 10:32:40Z inversion $
 * @copyright 2007 Viktoras Agejevas
 */

/**
 * FryHelper for generation of select tags for date selection
 * 
 * @author Viktoras Agejevas <inversion at users.sourceforge.net>
 */
class FryHelperSelectDate extends FryHelper {
	
	/**
	 * String containing generated selects
	 *
	 * @var string
	 */
	private $date = "";
	
	/**
	 * Years minus $now for year select 
	 *
	 * @var integer
	 */
	private $from = 3;
	
	/**
	 * Years plus $now for year select
	 *
	 * @var integer
	 */
	private $to = 0;
	
	
	
	/**
	 * Timestamp for selected date
	 * Also used as a base for calculations
	 * 
	 * @var integer
	 */
	private $now;
	
	
	/**
	 * Printed after each select
	 *
	 * @var string
	 */
	private $separator = "&nbsp;";
	
	/**
	 * Generates date select tags
	 * Usage: Fry->selectDate(array('year' => 'Y'), array('from' => 10))
	 * 
	 * @param array $params
	 */
	public function __construct($params = array()) {
		
		$this->now = time();
		
		if (count($params) == 2) {
			foreach($params[1] as $param => $value) {
				if (property_exists($this, $param)) {
					$this->$param = (string)$value;
				}
			}
		}
		
		if (isset($params[0])) {
			foreach($params[0] as $p => $value) {
				if (method_exists($this, 
						$method = "create" . ucfirst(strtolower($p)))) {
					$this->date .= $this->$method($value);
				}
			}
		} else {
			$this->date .= $this->createYear();
			$this->date .= $this->createMonth();
			$this->date .= $this->createDay();
			$this->date .= $this->createHour();
			$this->date .= $this->createMinute();
			$this->date .= $this->createSecond();			
		}
	}
	
	private function createYear($format = "Y") {

		if (!in_array($format, array('Y', 'o'))) {
			throw new FryHelperException('Wrong date fromat for year');
		}
		
		$year = date("Y", $this->now);
		$return = "<select name=\"date[year]\">\n";
		
		for($i = $year - abs($this->from); $i <= $year + abs($this->to); $i++) {
			$selected = $year == $i ? " selected=\"selected\"" : null;
			$return .= "<option value=\"$i\"$selected>$i</option>\n";
		}

		$return .= "</select>" . $this->separator . "\n";
		return $return;
	}

	private function createMonth($format = "m") {
		
		if (!in_array($format, array('n', 'm', 'M', 'F'))) {
			throw new FryHelperException('Wrong date fromat for months');
		}
		
		$month = date($format, $this->now);
		$return = "<select name=\"date[month]\">\n";

		for($i = 1; $i <= 12; $i++) {
			$time = strtotime(date('Y-' . sprintf('%02d', $i) . '-d'));
			$value = date($format, $time);
			$selected = $month == $value ? " selected=\"selected\"" : null;
			$return .= "<option value=\"$value\"$selected>$value</option>\n";
		}

		$return .= "</select>" . $this->separator . "\n";
		return $return;
	}
	
	private function createDay($format = "d") {
		
		if (!in_array($format, array('j', 'd'))) {
			throw new FryHelperException('Wrong date fromat for days');
		}
		
		$day = date($format, $this->now);
		$return = "<select name=\"date[day]\">\n";
		
		for($i = 1; $i <= 31; $i++) {
			$time = strtotime(date('Y-m-' . sprintf('%02d', $i)));
			$value = date($format, $time);
			$selected = $day == $value ? " selected=\"selected\"" : null;
			$return .= "<option value=\"$value\"$selected>$i</option>\n";
		}

		$return .= "</select>" . $this->separator . "\n";
		return $return;
	}
	
	private function createHour($format = "H") {
		
		if (!in_array($format, array('g', 'G', 'h', 'H'))) {
			throw new FryHelperException('Wrong date fromat for hours');
		}
		
		if (in_array($format, array('g', 'h'))) {
			$zeroes = false;
			$from = 1;
			$to = 12;
		} else {
			$zeroes = true;
			$from = 0;
			$to = 23;
		}
		
		$month = date($format, $this->now);
		$return = "<select name=\"date[hour]\">\n";
		
		for($i = $from; $i <= $to; $i++) {
			$value = $zeroes ? sprintf("%02d", $i) : $i;
			$selected = $month == $value ? " selected=\"selected\"" : null;
			$return .= "<option value=\"$value\"$selected>$i</option>\n";
		}

		$return .= "</select>" . $this->separator . "\n";
		return $return;
	}
	
	private function createMinute($format = "i") {
		
		if (!in_array($format, array('i'))) {
			throw new FryHelperException('Wrong date fromat for minutes');
		}
		
		$minute = date($format, $this->now);
		$return = "<select name=\"date[minute]\">\n";
		
		for($i = 0; $i <= 59; $i++) {
			$value = sprintf("%02d", $i);
			$selected = $minute == $value ? " selected=\"selected\"" : null;
			$return .= "<option value=\"$value\"$selected>$i</option>\n";
		}

		$return .= "</select>" . $this->separator . "\n";
		return $return;
	}
	
	private function createSecond($format = "s") {

		if (!in_array($format, array('s'))) {
			throw new FryHelperException('Wrong date fromat for seconds');
		}
		
		$sec = date($format, $this->now);
		$return = "<select name=\"date[second]\">\n";
		
		for($i = 0; $i <= 59; $i++) {
			$value = sprintf("%02d", $i);
			$selected = $sec == $value ? " selected=\"selected\"" : null;
			$return .= "<option value=\"$value\"$selected>$i</option>\n";
		}

		$return .= "</select>" . $this->separator . "\n";
		return $return;
	}
	
	public function output() {
		return $this->date;
	}
}

?>