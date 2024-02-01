<?php

class Emp_special_task_detail_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('task_detail_id', 'DESC');
		return $this->db->get('emp_special_task_detail');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_special_task_detail', $data);
	}

	function fetch_single($task_detail_id)
	{
		$this->db->where('task_detail_id', $task_detail_id);
		$query = $this->db->get('emp_special_task_detail');
		return $query->result_array();
	}

	function update_single($task_detail_id, $data)
	{
		$this->db->where('task_detail_id', $task_detail_id);
		$this->db->update('emp_special_task_detail', $data);
	}

	function delete_single($task_detail_id)
	{
		$this->db->where('task_detail_id', $task_detail_id);
		$this->db->delete('emp_special_task_detail');
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
