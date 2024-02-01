<?php

class Sys_user_pages_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('page_id', 'DESC');
		return $this->db->get('user_pages');
	}
	
	function insert($data)
	{
		$this->db->insert('user_pages', $data);
	}

	function fetch_single($page_id)
	{
		$this->db->where('page_id', $page_id);
		$query = $this->db->get('user_pages');
		return $query->result_array();
	}

	function update_single($page_id, $data)
	{
		$this->db->where('page_id', $page_id);
		$this->db->update('user_pages', $data);
	}

	function delete_single($page_id)
	{
		$this->db->where('page_id', $page_id);
		$this->db->delete('user_pages');
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
