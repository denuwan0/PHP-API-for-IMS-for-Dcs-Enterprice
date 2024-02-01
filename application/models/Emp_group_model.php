<?php

class Emp_group_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('emp_group_id', 'DESC');
		return $this->db->get('emp_group');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_group', $data);
	}

	function fetch_single($emp_group_id)
	{
		$this->db->select('*');
		$this->db->from('emp_group');
		$this->db->join('emp_grade', 'emp_group.emp_grade_id  = emp_grade.emp_grade_id','left');
		$this->db->join('emp_designation', 'emp_group.emp_designation_id  = emp_designation.emp_desig_id','left');
		$this->db->where('emp_group_id', $emp_group_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	function update_single($emp_group_id, $data)
	{
		$this->db->where('emp_group_id', $emp_group_id);
		$this->db->update('emp_group', $data);
	}

	function delete_single($emp_group_id)
	{
		$this->db->where('emp_group_id', $emp_group_id);
		$this->db->delete('emp_group');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_single_join($emp_group_id)
	{
		$this->db->select('*');
		$this->db->from('emp_group');
		$this->db->join('emp_grade', 'emp_group.emp_grade_id  = emp_grade.emp_grade_id','left');
		$this->db->join('emp_designation', 'emp_group.emp_designation_id  = emp_designation.emp_desig_id','left');
		$this->db->where('emp_group_id ', $emp_group_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('emp_group');
		$this->db->join('emp_grade', 'emp_group.emp_grade_id  = emp_grade.emp_grade_id','left');
		$this->db->join('emp_designation', 'emp_group.emp_designation_id  = emp_designation.emp_desig_id','left');
		$query = $this->db->get();
		return $query->result_array();
	}
		
	function fetch_all_by_emp_grade_id($emp_grade_id)
	{
		$this->db->where('emp_grade_id', $emp_grade_id);
		$this->db->where('is_active_emp_group', 1);
		$query = $this->db->get('emp_group');
		return $query;
	}
	
}
