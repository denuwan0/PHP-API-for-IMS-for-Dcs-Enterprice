<?php

class Country_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('country_id', 'ASC');
		return $this->db->get('country');
	}
	
	function fetch_all_active(){
		$this->db->order_by('country_id', 'ASC');
		$this->db->where('is_active_country', 1);
		return $this->db->get('country');
	}
	
	function insert($data)
	{
		$this->db->insert('country', $data);
	}

	function fetch_single($country_id)
	{
		$this->db->where('country_id', $country_id);
		$query = $this->db->get('country');
		return $query->result_array();
	}

	function update_single($country_id, $data)
	{
		$this->db->where('country_id', $country_id);
		$this->db->update('country', $data);
	}

	function delete_single($country_id)
	{
		$this->db->where('country_id', $country_id);
		$this->db->delete('country');
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
