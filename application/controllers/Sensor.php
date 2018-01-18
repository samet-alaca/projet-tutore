<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sensor extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->library('session');
		$this->load->model('SensorModel');
	}

	public function add() {
		$user = $this->session->user;
		if(!isset($user)) {
			redirect('/login');
		}

		$this->lang->load('sensor', $this->session->lang);

		$sensor = $this->input->post('sensor');
		$plant = $this->input->post('plant');
		$owner = $this->input->post('owner');

		$scripts = [];
		$links = [];

		if(isset($sensor)) {
			$exists = $this->SensorModel->sensorExists($sensor);
			if($exists) {
				$data['error'] = $this->lang->line('sensor_error_exists');
			} else {
				$user = (isset($owner)) ? $owner : $this->UserModel->getUser($this->session->user)->id;

				$data['sensor'] = (object) [
					'sensor' => $sensor,
					'owner' => $user,
					'plant' => (isset($plant)) ? $plant : NULL
				];

				$links = [
					"https://cdn.jsdelivr.net/npm/instantsearch.js@2.3.3/dist/instantsearch.min.css",
					"https://cdn.jsdelivr.net/npm/instantsearch.js@2.3.3/dist/instantsearch-theme-algolia.min.css"
				];

				$scripts = [
					base_url() . 'assets/add_plant.js',
					"https://cdn.jsdelivr.net/algoliasearch/3/algoliasearchLite.min.js",
					"https://cdn.jsdelivr.net/npm/instantsearch.js@2.3.3/dist/instantsearch.min.js"
				];
			}
		}

		if(isset($data['sensor']) && $data['sensor']->plant !== NULL) {
			$this->SensorModel->addSensor($data['sensor']->sensor, $data['sensor']->owner, $data['sensor']->plant);
			echo base_url() . '/profile';
			die();
		}

		$data['page'] = [
			'title' => $this->lang->line('sensor_title_add'),
			'scripts' => $scripts,
			'links' => $links
		];

		$this->load->view('templates/header', $data);
		$this->load->view('sensor/add', $data);
		$this->load->view('templates/footer');
	}

	public function add_sensor() {
		$user = $this->session->user;
		if(!isset($user)) {
			redirect('/login');
		}


		$this->load->view('templates/header', $data);
		$this->load->view('sensor/add', $data);
		$this->load->view('templates/footer');
	}

	public function index()	{
		$this->load->model('UserModel');
		$this->load->model('SensorModel');
		$data['page'] = [
			'title' => "Homepage"
		];

		$this->load->view('templates/header', $data);
		$this->load->view('homepage', $data);
		$this->load->view('templates/footer');
	}

	public function healthCheck() {
		$sensor = $this->input->get('sensor');
		$light = $this->input->get('light');
		$temp = $this->input->get('temp');
		$moisture = $this->input->get('moisture');
		$ph = $this->input->get('ph');

		if($sensor) {
			$message = "";
			$message .= ($light && $light == 1) ? 'light not ok<br>' : '';
			$message .= ($temp && $temp == 1) ? 'temp not ok<br>' : '';
			$message .= ($moisture && $moisture == 1) ? 'moisture not ok<br>' : '';
			$message .= ($ph && $ph == 1) ? 'ph not ok<br>' : '';

			$this->lang->load('user', $this->session->lang);
			$this->load->model('UserModel');
			$user = $this->SensorModel->getOwner($sensor);
			$sensor = $this->SensorModel->getSensor($sensor);
			$this->email->from('trustepot@gmail.com', 'Trust-ePot');
			$this->email->to($user->email);
			$this->email->subject('[Trust-ePot] : ' . $this->lang->line('user_healthcheck_title'));
			$this->email->message($this->lang->line('user_healthcheck_message') . $sensor->plant . '<br><br>' . $message);
			$this->email->send();
		}
	}
}
