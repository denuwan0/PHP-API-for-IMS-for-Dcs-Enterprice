<?php

class User_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('user_id', 'DESC');
		return $this->db->get('user');
	}
	
	function insert($data)
	{
		$this->db->insert('user', $data);
	}

	function fetch_single($user_id)
	{		
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user');
		var_dump($query->result_array());
	}

	function update_single($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
	}

	function delete_single($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('user');
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
