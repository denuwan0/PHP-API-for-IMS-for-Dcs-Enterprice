<?php

class Emp_special_task_header_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('special_task_id', 'DESC');
		return $this->db->get('emp_special_task_header');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_special_task_header', $data);
	}

	function fetch_single($special_task_id)
	{
		$this->db->where('special_task_id', $special_task_id);
		$query = $this->db->get('emp_special_task_header');
		return $query->result_array();
	}

	function update_single($special_task_id, $data)
	{
		$this->db->where('special_task_id', $special_task_id);
		$this->db->update('emp_special_task_header', $data);
	}

	function delete_single($special_task_id)
	{
		$this->db->where('special_task_id', $special_task_id);
		$this->db->delete('emp_special_task_header');
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
