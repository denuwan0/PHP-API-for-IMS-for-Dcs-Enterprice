<?php

class Branch_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('company_branch_id', 'ASC');
		return $this->db->get('company_branch');
	}
	
	function fetch_all_active(){
		$this->db->where('is_active_branch', 1);
		$this->db->order_by('company_branch_id', 'ASC');
		return $this->db->get('company_branch');
	}
	
	function fetch_all_active_by_emp_branch_id($company_branch_id){
		$this->db->where('is_active_branch', 1);
		$this->db->where('company_branch_id', $company_branch_id);
		$this->db->order_by('company_branch_id', 'ASC');
		return $this->db->get('company_branch');
	}
	
	function fetch_all_active_other_branches_by_emp_branch_id($company_branch_id){
		$this->db->where('is_active_branch', 1);
		$this->db->where_not_in('company_branch_id', $company_branch_id);
		$this->db->order_by('company_branch_id', 'ASC');
		return $this->db->get('company_branch');
	}
	
	function insert($data)
	{
		$this->db->insert('company_branch', $data);
	}

	function fetch_all_by_company_id($company_id)
	{
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('company_branch');
		return $query;
	}
	
	function fetch_all_by_location_id($location_id)
	{
		$this->db->where('location_id', $location_id);
		$query = $this->db->get('company_branch');
		return $query;
	}
	
	function fetch_single($company_branch_id)
	{
		$this->db->where('company_branch_id', $company_branch_id);
		$query = $this->db->get('company_branch');
		return $query->result_array();
	}

	function update_single($company_branch_id, $data)
	{
		$this->db->where('company_branch_id', $company_branch_id);
		$this->db->update('company_branch', $data);
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('company_branch');
		$this->db->join('location', 'company_branch.location_id = location.location_id','left');
		$this->db->join('company', 'company_branch.company_id = company.company_id','left');
		$this->db->join('emp_details', 'company_branch.branch_manager = emp_details.emp_id','left');
		//$this->db->where('company.company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	function delete_single($company_branch_id)
	{
		$this->db->where('company_branch_id', $company_branch_id);
		$this->db->delete('company_branch');
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
