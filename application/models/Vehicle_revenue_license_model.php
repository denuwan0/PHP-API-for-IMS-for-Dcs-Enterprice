<?php

class Vehicle_revenue_license_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('rev_license_id', 'DESC');
		return $this->db->get('vehicle_revenue_license');
	}
	
	function fetch_all_active(){
		$this->db->where('is_active_vhcl_rev_lice', 1);
		return $this->db->get('vehicle_revenue_license');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_revenue_license', $data);
	}

	function fetch_single($rev_license_id)
	{
		$this->db->where('rev_license_id', $rev_license_id);
		$query = $this->db->get('vehicle_revenue_license');
		return $query->result_array();
	}
	
	function fetch_all_by_vehicle_id($vehicle_id)
	{
		$this->db->where('vehicle_id', $vehicle_id);
		$query = $this->db->get('vehicle_revenue_license');
		return $query;
	}

	function update_single($rev_license_id, $data)
	{
		$this->db->where('rev_license_id', $rev_license_id);
		$this->db->update('vehicle_revenue_license', $data);
	}

	function delete_single($rev_license_id)
	{
		$this->db->where('rev_license_id', $rev_license_id);
		$this->db->delete('vehicle_revenue_license');
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
		$this->db->from('vehicle_revenue_license');
		$this->db->join('vehicle_details', 'vehicle_revenue_license.vehicle_id = vehicle_details.vehicle_id','left');		
		$query = $this->db->get();	
		return $query->result_array();
	}
	
	function fetch_single_join($id)
	{
		$this->db->select('*');
		$this->db->from('vehicle_revenue_license');
		$this->db->join('vehicle_details', 'vehicle_revenue_license.vehicle_id = vehicle_details.vehicle_id','left');	
		$this->db->where('vehicle_revenue_license.rev_license_id', $id);
		$query = $this->db->get();	
		return $query->result_array();
	}
	
}
