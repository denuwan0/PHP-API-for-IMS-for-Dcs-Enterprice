<?php

class Emp_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('emp_id', 'DESC');
		return $this->db->get('emp_details');
	}
	
	function fetch_all_active(){
		$this->db->order_by('emp_id', 'ASC');
		$this->db->where('is_active_emp', 1);
		return $this->db->get('emp_details');
	}
	
	function fetch_all_active_by_emp_branch_id($emp_branch_id){
		$this->db->order_by('emp_id', 'ASC');
		$this->db->where('is_active_emp', 1);
		$this->db->where('emp_branch_id', $emp_branch_id);
		return $this->db->get('emp_details');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_details', $data);
	}

	function fetch_single($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_details');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{		
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_details');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_epf($emp_epf)
	{		
		$this->db->where('emp_epf', $emp_epf);
		$query = $this->db->get('emp_details');
		return $query->result_array();
	}
	
	function fetch_single_by_mobile($emp_contact_no)
	{		
		$this->db->where('emp_contact_no', $emp_contact_no);
		$query = $this->db->get('emp_details');
		return $query->result_array();
	}
	
	function fetch_single_by_email($emp_email)
	{		
		$this->db->where('emp_email', $emp_email);
		$query = $this->db->get('emp_details');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_drive_license_id($emp_drive_license_id)
	{		
		$this->db->where('emp_drive_license_id', $emp_drive_license_id);
		$query = $this->db->get('emp_details');
		return $query->result_array();
	}

	function update_single($emp_id, $data)
	{
		$this->db->where('emp_id', $emp_id);
		$this->db->update('emp_details', $data);
	}

	function delete_single($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$this->db->delete('emp_details');
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
		$this->db->from('emp_details');
		$this->db->join('company_branch', 'emp_details.emp_branch_id = company_branch.company_branch_id','left');
		$this->db->join('company', 'emp_details.emp_company_id = company.company_id','left');
		//$this->db->where('company.company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_single_join($emp_id)
	{
		$this->db->select('*');
		$this->db->from('emp_details');
		$this->db->join('company_branch', 'emp_details.emp_branch_id = company_branch.company_branch_id','left');
		$this->db->join('company', 'emp_details.emp_company_id = company.company_id','left');
		$this->db->where('emp_details.emp_id', $emp_id );
		$query = $this->db->get();
		return $query->result_array();
	}
	
}
