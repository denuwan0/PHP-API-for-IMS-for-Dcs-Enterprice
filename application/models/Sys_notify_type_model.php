<?php

class Sys_notify_type_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('sys_notify_type_id', 'DESC');
		return $this->db->get('sys_notify_type');
	}
	
	function fetch_all_active(){
		$this->db->where('is_active_sys_notify_type', 1);
		return $this->db->get('sys_notify_type');
	}
	
	function insert($data)
	{
		$this->db->insert('sys_notify_type', $data);
	}

	function fetch_single($sys_notify_type_id)
	{
		$this->db->where('sys_notify_type_id', $sys_notify_type_id);
		$query = $this->db->get('sys_notify_type');
		return $query->result_array();
	}

	function update_single($sys_notify_type_id, $data)
	{
		$this->db->where('sys_notify_type_id', $sys_notify_type_id);
		$this->db->update('sys_notify_type', $data);
	}

	function delete_single($sys_notify_type_id)
	{
		$this->db->where('sys_notify_type_id', $sys_notify_type_id);
		$this->db->delete('sys_notify_type');
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
