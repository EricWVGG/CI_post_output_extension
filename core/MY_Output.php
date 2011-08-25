<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Output extends CI_Output {

	private $closures = array();

	public function do_closure_after_output($closure, $parameters = array()) {
		$this->closures[] = array('closure'=>$closure, 'parameters'=>$parameters);
	}
	
	public function _display($output = '') {
		
		if(!$this->closures) {
			// proceed as normal
			parent::_display($output);
			return;
		}
		
		// halt codeigniter output buffering
		ob_end_clean();
		
		// start our own output buffering, and close the http connection to the client
		ob_start();
		parent::_display($output);
		$size = ob_get_length();
		header("Content-Length: $size");
		header("Connection: close\r\n");
		ob_end_flush();
		flush();
		ob_end_clean();
		
		// run closures
		if($this->closures) {
			foreach($this->closures AS $closure) {
				extract($closure);
				$closure($parameters);
			}
		}
	}

}
