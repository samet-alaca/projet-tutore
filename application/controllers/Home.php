<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->library('session');
	}

	public function readTopic($topic, $message) {
		$this->SensorModel->addData($message);
	}

	public function index()	{
		$this->lang->load('home', $this->session->lang);
		$this->load->model('UserModel');
		$this->load->model('SensorModel');
		$data['page'] = [
			'title' => $this->lang->line('home_pagetitle')
		];
	
		$this->load->view('templates/header', $data);
		$this->load->view('homepage', $data);
		$this->load->view('templates/footer');
	}

	public function setLanguage() {
		$language = $this->input->post('language');
		$this->session->set_userdata('lang', $language);
	}

	public function plants() {
		$this->lang->load('plants', $this->session->lang);
		$data['page'] = [
			'title' => $this->lang->line("plants_title"),
			'links' => [
				"https://cdn.jsdelivr.net/npm/instantsearch.js@2.3.3/dist/instantsearch.min.css",
				"https://cdn.jsdelivr.net/npm/instantsearch.js@2.3.3/dist/instantsearch-theme-algolia.min.css"
			],
			'scripts' => [
				base_url() . 'assets/plants.js',
				"https://cdn.jsdelivr.net/algoliasearch/3/algoliasearchLite.min.js",
				"https://cdn.jsdelivr.net/npm/instantsearch.js@2.3.3/dist/instantsearch.min.js"
			]
		];

		$this->load->view('templates/header', $data);
		$this->load->view('plants/index', $data);
		$this->load->view('templates/footer');
	}
}
