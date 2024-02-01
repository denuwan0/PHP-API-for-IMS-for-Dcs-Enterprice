<?php

class Online_special_offers_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('offer_id', 'DESC');
		return $this->db->get('online_special_offers');
	}
	
	function insert($data)
	{
		$this->db->insert('online_special_offers', $data);
	}

	function fetch_single($offer_id)
	{
		$this->db->where('offer_id', $offer_id);
		$query = $this->db->get('online_special_offers');
		return $query->result_array();
	}

	function update_single($offer_id, $data)
	{
		$this->db->where('offer_id', $offer_id);
		$this->db->update('online_special_offers', $data);
	}
	
	function fetch_all_by_item_id($item_id)
	{
		$this->db->where('item_id', $item_id);
		$query = $this->db->get('online_special_offers');
		return $query;
	}

	function delete_single($offer_id)
	{
		$this->db->where('offer_id', $offer_id);
		$this->db->delete('online_special_offers');
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
