<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->helper('cookie');
		$this->load->library('email');
		$this->load->library('session');

		if(!$this->session->lang) {
			$this->session->set_userdata('lang', 'english');
		}

		$this->lang->load('navbar', $this->session->lang);

		if(!$this->session->logged_in) {
			$this->load->model('UserModel');
			$cookie = $this->input->cookie('remember');
			$parts = explode('//', $cookie);
			$user_id = $parts[0];
			$this->UserModel->verifyCookie($user_id, $cookie);
		}

	}

}
?>
