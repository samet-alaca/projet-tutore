<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function login($email, $password, $remember) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		$user = $this->db->get()->result();

		if(!is_array($user) || count($user) == 0) {
			return $this->lang->line('user_error_not_found');
		}

		$user = $user[0];

		if(!password_verify($password, $user->password)) {
			return $this->lang->line('user_error_password');
		}

		if(!$user->confirmed) {
			return $this->lang->line('user_error_confirmed');
		}

		if($remember) {
			$this->load->library('helper');
			$remember_token = $this->helper->random_str(60);
			$this->load->helper('cookie');

			set_cookie('remember', $user->id . '//' . $remember_token . sha1($user->id . 'oizeFdfGshHFUy878sYGuiHgGYUt5456tHJguyTGIU'), time() + 60 * 60 * 24 * 180);

			$this->db->insert('users_token', [
				'user' => $user->id,
				'token' => $remember_token,
				'label' => 'remember_token'
			]);
		}

		return true;
	}

	public function verifyCookie($user, $cookie) {
		$this->db->select('*');
		$this->db->from('users_token');
		$this->db->where('user', $user);
		$query = $this->db->get()->result_array();

		foreach($query as $row) {
			$expected = $row['user'] . '//' . $row['token'] . sha1($row['user'] . 'oizeFdfGshHFUy878sYGuiHgGYUt5456tHJguyTGIU');
			if($expected == $cookie) {
				$this->db->select('*');
				$this->db->from('users');
				$this->db->where('id', $row['user']);
				$user = $this->db->get()->result();
				if(is_array($user) && count($user) == 1) {
					$this->session->set_userdata('user', $user[0]->email);
				}
			}
		}
	}

	public function logout() {
		$this->db->where('user', $this->session->id);
		$this->db->where('label', 'remember_token');
		$this->db->delete('users_token');
	}

	public function register($user) {
		$this->load->helper('date');
		date_default_timezone_set("Europe/Paris");
		$account = [
			'email' => $user['email'],
			'password' => $user['password'],
			'confirmed' => NULL,
			'createdAt' => date("Y-m-d H:i:s"),
			'profileKey' => NULL
		];
		$account['profileKey'] = sha1($account['email'] . $account['createdAt']);

		$registered = $this->db->insert('users', $account);

		if($registered) {
			$registered = $this->db->insert_id();

			$this->db->insert('users_token', [
				'label' => 'registration_token',
				'token' => $user['registration_token'],
				'user'  => $registered
			]);
		}

		return $registered;
	}

	public function verifyConfirm($token) {
		$this->db->select('*');
		$this->db->from('users_token');
		$this->db->where('label', 'registration_token');
		$user = $this->db->get()->result();

		if(!is_array($user) || count($user) < 1) {
			return false;
		}

		$user = $user[0];
		if($user->token == $token) {
			$this->db->set('confirmed', true);
			$this->db->where('id', $user->user);
			$this->db->update('users');

			$this->db->select("profileKey");
			$this->db->from("users");
			$this->db->where("id", $user->user);
			$key = $this->db->get()->result();

			$this->db->where('token', $token);
			$this->db->delete('users_token');
			return (is_array($key) && count($key) > 0) ? $key[0]->profileKey : false;
		}
		return false;
	}

	public function getUser($email) {
		$this->db->select('*');
		$this->db->from("users");
		$this->db->where('email', $email);
		$user = $this->db->get()->result();

		return (!is_array($user) || count($user) < 1) ? false : $user[0];
	}

	public function getUserFromId($id) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id', $id);
		$user = $this->db->get()->result();

		return (!is_array($user) || count($user) < 1) ? false : $user[0];
	}

	public function setUserReset($user, $token) {
		$this->db->insert('users_token', [
			'label' => 'reset_token',
			'token' => $token,
			'user' => $user->id
		]);
	}

	public function verifyReset($token) {
		$this->db->select('*');
		$this->db->from('users_token');
		$this->db->where('label', 'reset_token');
		$user = $this->db->get()->result();

		return (is_array($user) && count($user) == 1 && $user[0]->token === $token) ? $user[0]->user : false;
	}

	public function resetPassword($password, $user) {
		$password_hashed = password_hash($password, PASSWORD_BCRYPT);

		$this->db->where('label', 'reset_token');
		$this->db->delete('users_token');

		$this->db->set('password', $password_hashed);
		$this->db->where('id', $user);
		$this->db->update('users');
	}

	public function getOption($user){
		$this->db->select('parameter');
		$this->db->from('users');
		$this->db->where('id', $user);
		$importJSON = $this->db->get()->result();
		return (is_array($importJSON) && count($importJSON) == 1) ? $importJSON[0]->parameter : false;
	}

	public function updateOption($optionJSON,$user){
		$this->db->set('parameter', $optionJSON);
		$this->db->where('id', $user);
		$this->db->update('users');
	}


}

?>
