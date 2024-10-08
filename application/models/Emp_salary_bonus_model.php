<?php

class Emp_salary_bonus_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('emp_bonus_id', 'DESC');
		return $this->db->get('emp_salary_bonus');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_salary_bonus', $data);
	}

	function fetch_single($emp_bonus_id)
	{
		$this->db->where('emp_bonus_id', $emp_bonus_id);
		$query = $this->db->get('emp_salary_bonus');
		return $query->result_array();
	}
	
	function fetch_single_by_bonus_id($bonus_id)
	{
		$this->db->where('bonus_id', $bonus_id);
		$query = $this->db->get('emp_salary_bonus');
		return $query;
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_salary_bonus');
		return $query;
	}

	function update_single($emp_bonus_id, $data)
	{
		$this->db->where('emp_bonus_id', $emp_bonus_id);
		$this->db->update('emp_salary_bonus', $data);
	}

	function delete_single($emp_bonus_id)
	{
		$this->db->where('emp_bonus_id', $emp_bonus_id);
		$this->db->delete('emp_salary_bonus');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_all_join(){
		$this->db->order_by('emp_bonus_id', 'ASC');
		$this->db->join('emp_bonus', 'emp_salary_bonus.bonus_id = emp_bonus.bonus_id','left');
		$this->db->join('emp_details', 'emp_salary_bonus.emp_id = emp_details.emp_id','left');
		$query = $this->db->get('emp_salary_bonus');
		//echo $this->db->last_query();
		return $query;
	}
	
	function fetch_all_join_by_branch_id($branch_id){
		
		$this->db->order_by('emp_bonus_id', 'ASC');
		$this->db->where('branch_id', $branch_id);	
		$this->db->join('emp_bonus', 'emp_salary_bonus.bonus_id = emp_bonus.bonus_id','left');
		$this->db->join('emp_details', 'emp_salary_bonus.emp_id = emp_details.emp_id','left');
		$query = $this->db->get('emp_salary_bonus');
		return $query;
	}
	
	function fetch_single_join($id){
		$this->db->order_by('emp_bonus_id', 'ASC');
		$this->db->where('emp_bonus_id', $id);
		$this->db->join('emp_bonus', 'emp_salary_bonus.bonus_id = emp_bonus.bonus_id','left');
		$this->db->join('emp_details', 'emp_salary_bonus.emp_id = emp_details.emp_id','left');
		$query = $this->db->get('emp_salary_bonus');
		//echo $this->db->last_query();
		return $query;
	}
	
}
