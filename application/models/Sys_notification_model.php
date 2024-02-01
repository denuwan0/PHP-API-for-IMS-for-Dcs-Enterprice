<?php

class Sys_notification_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('sys_notify_id', 'DESC');
		return $this->db->get('sys_notification');
	}
	
	function insert($data)
	{
		$this->db->insert('sys_notification', $data);
	}

	function fetch_single($sys_notify_id)
	{
		$this->db->where('sys_notify_id', $sys_notify_id);
		$query = $this->db->get('sys_notification');
		return $query->result_array();
	}
	
	function fetch_all_by_sys_notify_type_id($sys_notify_id)
	{
		$this->db->where('sys_notify_id', $sys_notify_id);
		$query = $this->db->get('sys_notification');
		return $query;
	}

	function update_single($sys_notify_id, $data)
	{
		$this->db->where('sys_notify_id', $sys_notify_id);
		$this->db->update('sys_notification', $data);
	}

	function delete_single($sys_notify_id)
	{
		$this->db->where('sys_notify_id', $sys_notify_id);
		$this->db->delete('sys_notification');
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
