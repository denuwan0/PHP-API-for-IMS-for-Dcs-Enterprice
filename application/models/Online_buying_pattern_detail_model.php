<?php

class Online_buying_pattern_detail_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('pattern_detail_id', 'DESC');
		return $this->db->get('online_buying_pattern_detail');
	}
	
	function insert($data)
	{
		$this->db->insert('online_buying_pattern_detail', $data);
	}

	function fetch_single($pattern_detail_id)
	{
		$this->db->where('pattern_detail_id', $pattern_detail_id);
		$query = $this->db->get('online_buying_pattern_detail');
		return $query->result_array();
	}

	function update_single($pattern_detail_id, $data)
	{
		$this->db->where('pattern_detail_id', $pattern_detail_id);
		$this->db->update('online_buying_pattern_detail', $data);
	}
	
	function fetch_all_by_item_id($item_id)
	{
		$this->db->where('item_id', $item_id);
		$query = $this->db->get('online_buying_pattern_detail');
		return $query;
	}

	function delete_single($pattern_detail_id)
	{
		$this->db->where('pattern_detail_id', $pattern_detail_id);
		$this->db->delete('online_buying_pattern_detail');
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
