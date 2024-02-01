<?php

class Vehicle_category_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('vehicle_category_id', 'DESC');
		return $this->db->get('vehicle_category');
	}
	
	function fetch_all_active(){
		$this->db->where('is_active_vhcl_cat', 1);
		$this->db->order_by('vehicle_category_id', 'DESC');
		return $this->db->get('vehicle_category');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_category', $data);
	}

	function fetch_single($vehicle_category_id)
	{
		$this->db->where('vehicle_category_id', $vehicle_category_id);
		$query = $this->db->get('vehicle_category');
		return $query->result_array();
	}

	function update_single($vehicle_category_id, $data)
	{
		$this->db->where('vehicle_category_id', $vehicle_category_id);
		$this->db->update('vehicle_category', $data);
	}

	function delete_single($vehicle_category_id)
	{
		$this->db->where('vehicle_category_id', $vehicle_category_id);
		$this->db->delete('vehicle_category');
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
