<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helper {
	
	/**
	* Returns random string with given length
	* @param int $length
	* @return string
	*/
	public function random_str($length) {
		return substr(str_shuffle(str_repeat("0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN", $length)), 0, $length);
	}
}
