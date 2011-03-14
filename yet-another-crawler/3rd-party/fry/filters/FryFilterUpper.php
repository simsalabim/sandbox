<?php

class FryFilterUpper extends FryFilter {
	
	public function filter() {
		return $this->caller->set(strtoupper((string)$this->caller->get()));
	}
}

?>