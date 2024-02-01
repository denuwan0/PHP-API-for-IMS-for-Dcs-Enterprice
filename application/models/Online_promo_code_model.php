<?php

class Online_promo_code_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('promo_code_id', 'DESC');
		return $this->db->get('online_promo_code');
	}
	
	function insert($data)
	{
		$this->db->insert('online_promo_code', $data);
	}

	function fetch_single($promo_code_id)
	{
		$this->db->where('promo_code_id', $promo_code_id);
		$query = $this->db->get('online_promo_code');
		return $query->result_array();
	}

	function update_single($promo_code_id, $data)
	{
		$this->db->where('promo_code_id', $promo_code_id);
		$this->db->update('online_promo_code', $data);
	}

	function delete_single($promo_code_id)
	{
		$this->db->where('promo_code_id', $promo_code_id);
		$this->db->delete('online_promo_code');
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
