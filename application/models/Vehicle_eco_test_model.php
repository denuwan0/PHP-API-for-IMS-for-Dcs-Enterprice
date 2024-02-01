<?php

class Vehicle_eco_test_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('eco_test_id', 'DESC');
		return $this->db->get('vehicle_eco_test');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_eco_test', $data);
	}

	function fetch_single($eco_test_id)
	{
		$this->db->where('eco_test_id', $eco_test_id);
		$query = $this->db->get('vehicle_eco_test');
		return $query->result_array();
	}
	
	function fetch_all_by_vehicle_id($vehicle_id)
	{
		$this->db->where('vehicle_id', $vehicle_id);
		$query = $this->db->get('vehicle_eco_test');
		return $query;
	}

	function update_single($eco_test_id, $data)
	{
		$this->db->where('eco_test_id', $eco_test_id);
		$this->db->update('vehicle_eco_test', $data);
	}

	function delete_single($eco_test_id)
	{
		$this->db->where('eco_test_id', $eco_test_id);
		$this->db->delete('vehicle_eco_test');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_all_join()
	{	
		$this->db->select('*');
		$this->db->from('vehicle_eco_test');
		$this->db->join('vehicle_details', 'vehicle_eco_test.vehicle_id = vehicle_details.vehicle_id','left');		
		$query = $this->db->get();	
		return $query->result_array();
	}
	
	function fetch_single_join($id)
	{
		$this->db->select('*');
		$this->db->from('vehicle_eco_test');
		$this->db->join('vehicle_details', 'vehicle_eco_test.vehicle_id = vehicle_details.vehicle_id','left');
		$this->db->where('vehicle_eco_test.eco_test_id', $id);
		$query = $this->db->get();	
		return $query->result_array();
	}
	
}
