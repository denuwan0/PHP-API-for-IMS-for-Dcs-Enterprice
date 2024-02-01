<?php

class Bank_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('bank_id', 'DESC');
		return $this->db->get('bank');
	}
	
	function fetch_all_join(){
		$this->db->order_by('bank_id', 'DESC');
		return $this->db->get('bank');
	}
	
	function insert($data)
	{
		$this->db->insert('bank', $data);
	}

	function fetch_single($bank_id)
	{
		$this->db->where('bank_id', $bank_id);
		$query = $this->db->get('bank');
		return $query->result_array();
	}

	function update_single($bank_id, $data)
	{
		$this->db->where('bank_id', $bank_id);
		$this->db->update('bank', $data);
	}
	
	function fetch_all_active(){
		$this->db->order_by('bank_id', 'ASC');
		$this->db->where('is_active_bank', 1);
		return $this->db->get('bank');
	}

	function delete_single($bank_id)
	{
		$this->db->where('bank_id', $bank_id);
		$this->db->delete('bank');
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
