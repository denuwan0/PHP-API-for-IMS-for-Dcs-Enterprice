<?php

class Emp_work_schedule_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('ws_id', 'DESC');
		return $this->db->get('emp_work_schedule');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_work_schedule', $data);
	}

	function fetch_single($ws_id)
	{
		$this->db->where('ws_id', $ws_id);
		$query = $this->db->get('emp_work_schedule');
		return $query->result_array();
	}

	function update_single($ws_id, $data)
	{
		$this->db->where('ws_id', $ws_id);
		$this->db->update('emp_work_schedule', $data);
	}

	function delete_single($ws_id)
	{
		$this->db->where('ws_id', $ws_id);
		$this->db->delete('emp_work_schedule');
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
		$this->db->from('emp_work_schedule');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_single_join($ws_id)
	{
		$this->db->select('*');
		$this->db->from('emp_work_schedule');
		$this->db->where('ws_id ', $ws_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	function fetch_all_active(){
		$this->db->where('is_active_work_schedule', 1);
		return $this->db->get('emp_work_schedule');
	}
}
