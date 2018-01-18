<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('recaptcha');
		$this->load->library('helper');
		$this->lang->load('user', $this->session->lang);
	}

	public function login() {
		$data['page'] = [
			'title' => $this->lang->line('user_title_login')
		];

		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$remember = $this->input->post('remember');

		if($email && $password) {
			$response = $this->UserModel->login($email, $password, $remember);
			if($response === true) {
				$this->session->set_userdata('user', $email);
				redirect('profile');
			} else {
				$data['error'] = $response;
			}
		}
		$this->load->view('templates/header', $data);
		$this->load->view('user/login', $data);
		$this->load->view('templates/footer');
	}

	public function logout() {
		$this->UserModel->logout();
		$this->session->sess_destroy();
		delete_cookie('remember');
		redirect('');
	}

	public function register() {
		$data['page'] = [
			'title' => $this->lang->line('user_title_register'),
			'scripts' => [ 'https://www.google.com/recaptcha/api.js' ]
		];

		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$pwd_confirm = $this->input->post('password_confirm');
		$captcha = $this->input->post('g-recaptcha-response');

		if($email && $password) {
			$data['error'] = false;
			$this->recaptcha->set('6LcCdRQUAAAAADzBRBrDz_FRtq5aYz9OKZxw1bV_', '6LcCdRQUAAAAAN2zePHYz7QpLCHR7wuBp26GEIe4');

			//if(!$this->recaptcha->verifyCaptcha($captcha)) {
			//	$data['error'] = $this->lang->line('user_error_captcha');
			//}

			if($password != $pwd_confirm) {
				$data['error'] = $this->lang->line('user_error_password_match');
			}

			if(!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
				$data['error'] = $this->lang->line('user_error_email');
			}

			if($this->UserModel->getUser($email)) {
				$data['error'] = $this->lang->line('user_error_exists');
			}

			if(!$data['error']) {
				$token = $this->helper->random_str(60);

				$this->email->from('trustepot@gmail.com', 'Trust-ePot');
				$this->email->to($email);
				$this->email->subject('[Trust-ePot] : ' . $this->lang->line('user_email_title_confirm'));
				$this->email->message('<a href="' . base_url() . 'confirm/' . $token . '">'. $this->lang->line('user_email_confirm') .'</a>');
				$this->email->send();

				$this->UserModel->register([
					'email' => $email,
					'password' => password_hash($password, PASSWORD_BCRYPT),
					'registration_token' => $token
				]);
			}
		}

		$this->load->view('templates/header', $data);
		$this->load->view('user/register', $data);
		$this->load->view('templates/footer');
	}

	public function confirm($token) {
		$response = $this->UserModel->verifyConfirm($token);

		if($response !== false) {
			$url = 'http://subscriber.nelva.fr';

			$data = array('subscribe' => 'plants/' . $response);

			$options = array(
				'http' => array(
					'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					'method'  => 'POST',
					'content' => http_build_query($data)
				)
			);

			file_get_contents($url, false, stream_context_create($options));
		}

			
		redirect('login');
		
	}

	public function forgot() {
		$data['page'] = [
			'title' => $this->lang->line('user_title_forgot')
		];

		$email = $this->input->post('email');

		if($email) {
			$data['error'] = false;

			$user = $this->UserModel->getUser($email);

			if(!$user) {
				$data['error'] = $this->lang->line('user_error_not_found');
			}

			if(!$data['error']) {
				$token = $this->helper->random_str(60);

				$this->email->from('trusepot@gmail.com', 'Trust-ePot');
				$this->email->to($email);
				$this->email->subject('[Trust-ePot] : ' . $this->lang->line('user_email_title_forgot'));
				$this->email->message('<a href="' . base_url() . 'confirm/' . $token . '">'. $this->lang->line('user_email_forgot') .'</a>');
				$this->email->send();

				$this->UserModel->setUserReset($user, $token);
			}
		}

		$this->load->view('templates/header', $data);
		$this->load->view('user/forgot', $data);
		$this->load->view('templates/footer');
	}

	public function reset($token) {
		$data['page'] = [
			'title' => $this->lang->line('user_title_forgot')
		];

		$user = $this->UserModel->verifyReset($token);
		$data['reset'] = ($user !== false);

		$password = $this->input->post("password");
		$pwd_confirm = $this->input->post("password_confirm");

		if($password && $pwd_confirm) {
			if($password != $pwd_confirm) {
				$data['error'] = $this->lang->line('user_error_password_match');
			} else {
				$data['error'] = false;
				$this->UserModel->resetPassword($password, $user);
			}
		}

		$this->load->view('templates/header', $data);
		$this->load->view('user/forgot', $data);
		$this->load->view('templates/footer');
	}

	public function profile() {
		$data['page'] = [
			'title' => $this->lang->line('user_title_account')
		];

		$user = $this->UserModel->getUser($this->session->user);
		if($user) {
			$this->load->model('SensorModel');
			$data['sensors'] = $this->SensorModel->getSensors($user->id);
		} else {
			redirect('login');
		}

		$this->load->view('templates/header', $data);
		$this->load->view('user/profile', $data);
		$this->load->view('templates/footer');
	}
	
	public function option(){
		$data['page'] = [
			'title' => $this->lang->line('user_option_pagetitle')
		]; 
		$user = $this->UserModel->getUser($this->session->user);
		if(!$user)redirect('login');
		if ($this->input->post('time_lim')){
			$ok = "ok";
			$option = new stdClass();
			$option->time_lim = $this->input->post('time_lim');
			$option->temp = "0";
			$option->pH = "0";
			$option->moisture = "0";
			$option->light = "0";
			if ($this->input->post('temp'))$option->temp = "1";
			if ($this->input->post('pH'))$option->pH = "1";
			if ($this->input->post('light'))$option->light = "1";
			if ($this->input->post('moisture'))$option->moisture = "1";
			
			$optionJSON = json_encode($option);
			$this->UserModel->updateOption($optionJSON,$user->id);
			$data['success']=true;
		}		
			
		$importJSON = $this->UserModel->getOption($user->id);
		
		if ($importJSON){
			$parameter = json_decode($importJSON);
			$data['parameter'] = $parameter;
		}

		$this->load->view('templates/header', $data);
		$this->load->view('user/option', $data);
		$this->load->view('templates/footer');
		
	}

		public function data($sensor) {
		$data['page'] = [
			'title' => $this->lang->line('user_sensor'),
			'scripts' => [
				'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js',
				base_url() . 'assets/data.js'
			]
		];

		$chart = $this->input->post('chartjs');
		$user = $this->UserModel->getUser($this->session->user);
		
		if($user) {
			$this->load->model('SensorModel');
			if($chart) {
				$sensor_data = json_encode($this->SensorModel->getData($user->id, $sensor));
				echo $sensor_data;
			} else {
				$data['sensor'] = $this->SensorModel->getSensor($sensor);
				$this->load->view('templates/header', $data);
				$this->load->view('user/data', $data);
				$this->load->view('templates/footer');
			}
		} else {
			redirect('login');
		}
	}
}

