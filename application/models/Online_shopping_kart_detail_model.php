<?php

class Online_shopping_kart_detail_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('kart_detail_id', 'DESC');
		return $this->db->get('online_shopping_kart_detail');
	}
	
	function insert($data)
	{
		$this->db->insert('online_shopping_kart_detail', $data);
	}

	function fetch_single($kart_detail_id)
	{
		$this->db->where('kart_detail_id', $kart_detail_id);
		$query = $this->db->get('online_shopping_kart_detail');
		return $query->result_array();
	}

	function update_single($kart_detail_id, $data)
	{
		$this->db->where('kart_detail_id', $kart_detail_id);
		$this->db->update('online_shopping_kart_detail', $data);
	}
	
	function fetch_all_by_item_id($item_id)
	{
		$this->db->where('item_id', $item_id);
		$query = $this->db->get('online_shopping_kart_detail');
		return $query;
	}

	function delete_single($kart_detail_id)
	{
		$this->db->where('kart_detail_id', $kart_detail_id);
		$this->db->delete('online_shopping_kart_detail');
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
