<?php

class FryFilterLower extends FryFilter {
	
	public function filter() {
		return $this->caller->set(strtolower((string)$this->caller->get()));
	}
}

?>