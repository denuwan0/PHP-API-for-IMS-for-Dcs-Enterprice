<?php

class Emp_salary_advance_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('emp_salary_advance_id', 'ASC');
		return $this->db->get('emp_salary_advance');
	}
	
	function fetch_all_join(){
		$this->db->order_by('emp_salary_advance_id', 'ASC');
		$this->db->join('emp_advance', 'emp_salary_advance.advance_id = emp_advance.advance_id','left');
		$this->db->join('emp_details', 'emp_salary_advance.emp_id = emp_details.emp_id','left');
		return $this->db->get('emp_salary_advance');
	}
	
	function fetch_single_join($id){
		$this->db->order_by('emp_salary_advance_id', 'ASC');
		$this->db->where('emp_salary_advance_id', $id);
		$this->db->join('emp_advance', 'emp_salary_advance.advance_id = emp_advance.advance_id','left');
		$this->db->join('emp_details', 'emp_salary_advance.emp_id = emp_details.emp_id','left');
		$query = $this->db->get('emp_salary_advance');
		return $query->result_array();
	}
	
	function fetch_all_join_by_branch_id($branch_id){
		$this->db->order_by('emp_salary_advance_id', 'ASC');
		$this->db->where('branch_id', $branch_id);
		$this->db->join('emp_advance', 'emp_salary_advance.advance_id = emp_advance.advance_id','left');
		$this->db->join('emp_details', 'emp_salary_advance.emp_id = emp_details.emp_id','left');
		return $this->db->get('emp_salary_advance');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_salary_advance', $data);
	}

	function fetch_single($emp_salary_advance_id)
	{
		$this->db->where('emp_salary_advance_id', $emp_salary_advance_id);
		$query = $this->db->get('emp_salary_advance');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_salary_advance_id($emp_salary_advance_id)
	{
		$this->db->where('emp_salary_advance_id', $emp_salary_advance_id);
		$query = $this->db->get('emp_salary_advance');
		return $query;
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_salary_advance');
		return $query;
	}

	function update_single($emp_salary_advance_id, $data)
	{
		$this->db->where('emp_salary_advance_id', $emp_salary_advance_id);
		$this->db->update('emp_salary_advance', $data);
	}

	function delete_single($emp_salary_advance_id)
	{
		$this->db->where('emp_salary_advance_id', $emp_salary_advance_id);
		$this->db->delete('emp_salary_advance');
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
