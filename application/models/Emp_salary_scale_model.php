<?php

class Emp_salary_scale_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('sal_scale_id', 'DESC');
		return $this->db->get('emp_salary_scale');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_salary_scale', $data);
	}

	function fetch_single($sal_scale_id)
	{
		$this->db->where('sal_scale_id', $sal_scale_id);
		$query = $this->db->get('emp_salary_scale');
		return $query->result_array();
	}

	function update_single($sal_scale_id, $data)
	{
		$this->db->where('sal_scale_id', $sal_scale_id);
		$this->db->update('emp_salary_scale', $data);
	}

	function delete_single($sal_scale_id)
	{
		$this->db->where('sal_scale_id', $sal_scale_id);
		$this->db->delete('emp_salary_scale');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	function fetch_all_by_emp_group_id($emp_group_id)
	{
		$this->db->where('emp_group_id', $emp_group_id);
		$this->db->where('is_active_sal_scale', 1);
		$query = $this->db->get('emp_salary_scale');
		return $query;
	}
	
}
