<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post_output_test_controller extends CI_Controller {


	function index() {
		
		// Load your view. 
		// This can be done at the end of the method if you prefer, makes no difference.
		$this->load->view('post_output_test', array('time' => time()));

		// Wrap up any parameters you will need here.
		$parameters = array('message' => 'Logged at: ');
		
		// If you need to call CI methods, include it here.
		// 	$parameters['CI'] &= get_instance();
		
		$my_closure = function( $parameters ) {
			extract($parameters);

			// Your post-output code goes here.
			sleep(30);
			$message .= date(DATE_RSS, time()) . "\n";
			file_put_contents(APPPATH.'/logs/post_output_test.log', $message, FILE_APPEND|LOCK_EX);
				
			// If you need any Codeigniter methods, call like so:
			// 		$CI->db->query( "SELECT * from etc. do stuff" );
		};
		
		// Insert the closure.
		$this->output->do_closure_after_output($my_closure, $parameters);
		
		// You can do as many as you like.
		//		$this->output->do_closure_after_output($another_closure, $more_parameters);
		
	}


}
