<?php

class Sys_user_permission_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('user_permission_id', 'DESC');
		return $this->db->get('user_permission');
	}
	
	function insert($data)
	{
		$this->db->insert('user_permission', $data);
	}

	function fetch_single($user_permission_id)
	{
		$this->db->where('user_permission_id', $user_permission_id);
		$query = $this->db->get('user_permission');
		return $query->result_array();
	}

	function update_single($user_permission_id, $data)
	{
		$this->db->where('user_permission_id', $user_permission_id);
		$this->db->update('user_permission', $data);
	}

	function delete_single($user_permission_id)
	{
		$this->db->where('user_permission_id', $user_permission_id);
		$this->db->delete('user_permission');
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
