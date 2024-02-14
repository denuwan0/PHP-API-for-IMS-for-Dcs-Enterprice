<?php

class Emp_salary_allowance_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('emp_salary_allowance_id', 'DESC');
		return $this->db->get('emp_salary_allowance');
	}
	
	function fetch_all_active(){
		$this->db->order_by('emp_salary_allowance_id', 'DESC');
		$this->db->where('is_active_sal_allow', 1);
		return $this->db->get('emp_salary_allowance');
	}
		
	function fetch_all_join(){
		$this->db->order_by('emp_salary_allowance_id', 'ASC');
		$this->db->join('emp_allowance', 'emp_salary_allowance_id.allowance_id = emp_allowance.allowance_id','left');
		$this->db->join('emp_details', 'emp_salary_allowance_id.emp_id = emp_details.emp_id','left');
		$query = $this->db->get('emp_salary_allowance');
		//echo $this->db->last_query();
		return $query;
	}
	
	function fetch_all_join_by_branch_id($branch_id){
		
		$this->db->order_by('emp_salary_allowance_id', 'ASC');
		$this->db->where('branch_id', $branch_id);	
		$this->db->join('emp_allowance', 'emp_salary_allowance.allowance_id = emp_allowance.allowance_id','left');
		$this->db->join('emp_details', 'emp_salary_allowance.emp_id = emp_details.emp_id','left');
		$query = $this->db->get('emp_salary_allowance');
		return $query;
	}
	
	function insert($data)
	{
		$this->db->insert('emp_salary_allowance', $data);
	}
	
	function fetch_single_join($emp_salary_allowance_id){
		
		$this->db->order_by('emp_salary_allowance_id', 'ASC');
		$this->db->join('emp_allowance', 'emp_salary_allowance.emp_salary_allowance_id = emp_allowance.allowance_id','left');
		$this->db->join('emp_details', 'emp_salary_allowance.emp_id = emp_details.emp_id','left');
		$this->db->where('emp_salary_allowance_id', $emp_salary_allowance_id);
		$query = $this->db->get('emp_salary_allowance');
		return $query->result_array();
	}

	function fetch_single($emp_salary_allowance_id)
	{
		$this->db->where('emp_salary_allowance_id', $emp_salary_allowance_id);
		$query = $this->db->get('emp_salary_allowance');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_salary_allowance');
		return $query;
	}
	
	function fetch_single_by_allowance_id($allowance_id)
	{
		$this->db->where('allowance_id', $allowance_id);
		$query = $this->db->get('emp_salary_allowance');
		return $query;
	}

	function update_single($emp_salary_allowance_id, $data)
	{
		$this->db->where('emp_salary_allowance_id', $emp_salary_allowance_id);
		$this->db->update('emp_salary_allowance', $data);
	}

	function delete_single($emp_salary_allowance_id)
	{
		$this->db->where('emp_salary_allowance_id', $emp_salary_allowance_id);
		$this->db->delete('emp_salary_allowance');
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
