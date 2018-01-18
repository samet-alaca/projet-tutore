<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recaptcha {

	/**
	* Recaptcha private code
	* @access private
	* @var string
	*/
	private $api_secret;

	/**
	* Recaptcha public code
	* @access private
	* @var string
	*/
	private $api_public;

	/**
	* Constructor.
	* @return void
	*/
	public function __construct() {

	}


	/**
	* Sets keys
	* @param string $api_public
	* @param string $api_secret
	* @return void
	*/
	public function set($api_public, $api_secret) {
		$this->api_secret = $api_secret;
		$this->api_public = $api_public;
	}

	/**
	* Verify captcha response
	* @param string $code
	* @param string $ip
	* @return bool
	*/
	public function verifyCaptcha($code, $ip = null) {
		if(empty($code)) {
			return false;
		}

		$ip = (is_null($ip)) ? $_SERVER['REMOTE_ADDR'] : $ip;
		$params = http_build_query([
			'secret' 	=> $this->api_secret,
			'response' 	=> $code,
			'remoteip' 	=> $ip
		]);

		$url = "https://www.google.com/recaptcha/api/siteverify?" . $params;

		if(function_exists('curl_version')) {
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_TIMEOUT, 3);
			$response = curl_exec($curl);
		} else {
			$response = file_get_contents($url);
		}

		if(empty($response) || is_null($response)) {
			return false;
		}

		return json_decode($response)->success;
	}
}
?>
