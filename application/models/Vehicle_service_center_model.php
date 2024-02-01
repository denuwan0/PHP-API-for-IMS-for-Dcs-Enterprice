<?php

class Vehicle_service_center_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('service_center_id', 'DESC');
		return $this->db->get('vehicle_service_center');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_service_center', $data);
	}

	function fetch_single($service_center_id)
	{
		$this->db->where('service_center_id', $service_center_id);
		$query = $this->db->get('vehicle_service_center');
		return $query->result_array();
	}

	function update_single($service_center_id, $data)
	{
		$this->db->where('service_center_id', $service_center_id);
		$this->db->update('vehicle_service_center', $data);
	}

	function delete_single($service_center_id)
	{
		$this->db->where('service_center_id', $service_center_id);
		$this->db->delete('vehicle_service_center');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
}
