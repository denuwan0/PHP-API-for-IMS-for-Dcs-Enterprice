<?php

class Vehicle_service_details_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('service_detail_id', 'DESC');
		return $this->db->get('vehicle_service_details');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_service_details', $data);
	}

	function fetch_single($service_detail_id)
	{
		$this->db->where('service_detail_id', $service_detail_id);
		$query = $this->db->get('vehicle_service_details');
		return $query->result_array();
	}

	function update_single($service_detail_id, $data)
	{
		$this->db->where('service_detail_id', $service_detail_id);
		$this->db->update('vehicle_service_details', $data);
	}

	function delete_single($service_detail_id)
	{
		$this->db->where('service_detail_id', $service_detail_id);
		$this->db->delete('vehicle_service_details');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_all_by_service_center_id($service_center_id)
	{
		$this->db->where('service_center_id', $service_center_id);
		$query = $this->db->get('vehicle_service_details');
		return $query;
	}
	
}
