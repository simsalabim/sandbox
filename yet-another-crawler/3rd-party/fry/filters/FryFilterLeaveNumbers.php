<?php

class FryFilterLeaveNumbers extends FryFilter {
	
	public function filter() {
		$result = preg_replace('/([^0-9])/', '', $this->caller->get());
		return $this->caller->set((int)$result);
	}
	
}

?>