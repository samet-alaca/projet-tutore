<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SensorModel extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function sensorExists($sensor) {
		$this->db->select('*');
		$this->db->from('sensors');
		$this->db->where('id', $sensor);
		$query = $this->db->get()->result();

		return (is_array($query) && count($query) > 0);
	}

	public function addSensor($sensor, $owner, $plant) {
		$this->db->insert('sensors', [
			'id' => $sensor,
			'owner' => $owner,
			'plant' => $plant
		]);
	}

	public function getOwner($sensor) {
		$this->db->select('owner');
		$this->db->from('sensors');
		$this->db->where('id', $sensor);
		$query = $this->db->get()->result();

		if(is_array($query) && count($query) > 0) {
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('id', $query[0]->owner);
			$user = $this->db->get()->result();
			return (is_array($user) && count($user) > 0) ? $user[0] : false;
		}
	}

	public function getSensor($sensor) {
		$this->db->select('*');
		$this->db->from('sensors');
		$this->db->where('id', $sensor);
		$query = $this->db->get()->result();

		return (is_array($query) && count($query) > 0) ? $query[0] : false;

	}

	public function getSensors($owner) {
		$this->db->select('*');
		$this->db->from('sensors');
		$this->db->where('owner', $owner);
		$query = $this->db->get()->result();

		return $query;
	}

	public function getData($owner, $sensor) {
		$this->db->select('*');
		$this->db->from('sensors');
		$this->db->where('owner', $owner);
		$this->db->where('sensor', $sensor);
		$this->db->join('sensors_data', 'sensors.id = sensors_data.sensor');
		$query = $this->db->get()->result();

		return $query;
	}
}
