<?php

class Vehicle_details_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('vehicle_id', 'DESC');
		return $this->db->get('vehicle_details');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_details', $data);
	}
	
	function fetch_all_active(){
		$this->db->where('is_active_vhcl_details', 1);
		$this->db->order_by('vehicle_id', 'DESC');
		return $this->db->get('vehicle_details');
	}

	function fetch_single($vehicle_id)
	{
		$this->db->where('vehicle_id', $vehicle_id);
		$query = $this->db->get('vehicle_details');
		return $query->result_array();
	}
	
	function fetch_all_by_branch_id($branch_id)
	{
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get('vehicle_details');
		return $query;
	}
	
	function fetch_all_by_vehicle_type_id($vehicle_type_id)
	{
		$this->db->where('vehicle_type_id', $vehicle_type_id);
		$query = $this->db->get('vehicle_details');
		return $query;
	}
	
	function fetch_all_by_vehicle_category_id($vehicle_category_id)
	{
		$this->db->where('vehicle_category_id', $vehicle_category_id);
		$query = $this->db->get('vehicle_details');
		return $query;
	}

	function update_single($vehicle_id, $data)
	{
		$this->db->where('vehicle_id', $vehicle_id);
		$this->db->update('vehicle_details', $data);
	}

	function delete_single($vehicle_id)
	{
		$this->db->where('vehicle_id', $vehicle_id);
		$this->db->delete('vehicle_details');
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
		$this->db->from('vehicle_details');
		$this->db->join('vehicle_type', 'vehicle_details.vehicle_type_id = vehicle_type.vehicle_type_id','left');
		$this->db->join('company_branch', 'vehicle_details.branch_id = company_branch.company_branch_id','left');
		$this->db->join('vehicle_category', 'vehicle_details.vehicle_category_id = vehicle_category.vehicle_category_id','left');
		//$this->db->where('company.company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_single_join($id)
	{
		$this->db->select('*');
		$this->db->from('vehicle_details');
		$this->db->join('vehicle_type', 'vehicle_details.vehicle_type_id = vehicle_type.vehicle_type_id','left');
		$this->db->join('company_branch', 'vehicle_details.branch_id = company_branch.company_branch_id','left');
		$this->db->join('vehicle_category', 'vehicle_details.vehicle_category_id = vehicle_category.vehicle_category_id','left');
		$this->db->where('vehicle_details.vehicle_id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
}
