<?php

class Vehicle_repair_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('repair_id', 'DESC');
		return $this->db->get('vehicle_repair');
	}
	
	function fetch_all_active(){
		$this->db->order_by('repair_id', 'ASC');
		$this->db->where('is_active_vhcl_repair', 1);
		return $this->db->get('vehicle_repair');
	}
	
	function fetch_all_active_and_complete(){
		$this->db->order_by('repair_id', 'ASC');
		$this->db->where('is_active_vhcl_repair', 1);
		$this->db->where('is_complete', 1);
		return $this->db->get('vehicle_repair');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_repair', $data);
	}

	function fetch_single($repair_id)
	{
		$this->db->where('repair_id', $repair_id);
		$query = $this->db->get('vehicle_repair');
		return $query->result_array();
	}
	
	function fetch_all_by_vehicle_id($vehicle_id)
	{
		$this->db->where('vehicle_id', $vehicle_id);
		$query = $this->db->get('vehicle_repair');
		return $query;
	}

	function update_single($repair_id, $data)
	{
		$this->db->where('repair_id', $repair_id);
		$this->db->update('vehicle_repair', $data);
	}

	function delete_single($repair_id)
	{
		$this->db->where('repair_id', $repair_id);
		$this->db->delete('vehicle_repair');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_single_join($repair_id)
	{
		$this->db->select('*');
		$this->db->from('vehicle_repair');	
		$this->db->join('vehicle_details', 'vehicle_repair.vehicle_id = vehicle_details.vehicle_id','left');
		$this->db->join('vehicle_repair_location', 'vehicle_repair.repair_location = vehicle_repair_location.repair_loc_id','left');
		$this->db->where('vehicle_repair.repair_id ', $repair_id);
		$query = $this->db->get();	
		return $query->result_array();
	}
	
	function fetch_all_join()
	{	
		$this->db->select('*');
		$this->db->from('vehicle_repair');	
		$this->db->join('vehicle_details', 'vehicle_repair.vehicle_id = vehicle_details.vehicle_id','left');
		$this->db->join('vehicle_repair_location', 'vehicle_repair.repair_location = vehicle_repair_location.repair_loc_id','left');
		$query = $this->db->get();	
		return $query->result_array();
	}
	
	function fetch_all_active_join(){
		$this->db->select('*');
		$this->db->from('vehicle_repair');
		$this->db->where('is_active_vhcl_repair', 1);
		$this->db->join('vehicle_details', 'vehicle_repair.vehicle_id = vehicle_details.vehicle_id','left');
		$this->db->join('vehicle_repair_location', 'vehicle_repair.repair_location = vehicle_repair_location.repair_loc_id','left');
		$query = $this->db->get();	
		return $query->result_array();
	}
	
	function fetch_all_active_and_complete_join(){		
		$this->db->select('*');
		$this->db->from('vehicle_repair');
		$this->db->where('is_active_vhcl_repair', 1);
		$this->db->where('is_complete', 1);
		$this->db->join('vehicle_details', 'vehicle_repair.vehicle_id = vehicle_details.vehicle_id','left');
		$this->db->join('vehicle_repair_location', 'vehicle_repair.repair_location = vehicle_repair_location.repair_loc_id','left');
		$query = $this->db->get();	
		return $query->result_array();
	}
	
}
