<?php

class Api_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('company_id', 'DESC');
		return $this->db->get('company');
	}
	
	function insert_api($data)
	{
		$this->db->insert('tbl_sample', $data);
	}

	function fetch_single($user_id)
	{
		$this->db->where('id', $user_id);
		$query = $this->db->get('tbl_sample');
		return $query->result_array();
	}

	function update_api($user_id, $data)
	{
		$this->db->where('id', $user_id);
		$this->db->update('tbl_sample', $data);
	}

	function delete_single_user($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->delete('tbl_sample');
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
