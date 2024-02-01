<?php

class Vehicle_repair_location_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('repair_loc_id', 'DESC');
		$query =$this->db->get('vehicle_repair_location');
		return $query->result_array();
	}
	
	function fetch_all_active(){
		$this->db->order_by('repair_loc_id', 'ASC');
		$this->db->where('is_active_vhcl_repair_loc', 1);
		return $this->db->get('vehicle_repair_location');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_repair_location', $data);
	}

	function fetch_single($repair_loc_id)
	{
		$this->db->where('repair_loc_id', $repair_loc_id);
		$query = $this->db->get('vehicle_repair_location');
		return $query->result_array();
	}

	function update_single($repair_loc_id, $data)
	{
		$this->db->where('repair_loc_id', $repair_loc_id);
		$this->db->update('vehicle_repair_location', $data);
	}

	function delete_single($repair_loc_id)
	{
		$this->db->where('repair_loc_id', $repair_loc_id);
		$this->db->delete('vehicle_repair_location');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_single_join($id)
	{
		$this->db->select('*');
		$this->db->from('vehicle_repair_location');	
		$this->db->where('vehicle_repair_location.repair_loc_id', $id);
		$query = $this->db->get();	
		return $query->result_array();
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('vehicle_repair_location');	
		$query = $this->db->get();	
		return $query->result_array();
	}
}
