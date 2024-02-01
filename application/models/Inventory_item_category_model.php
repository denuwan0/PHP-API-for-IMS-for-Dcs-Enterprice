<?php

class Inventory_item_category_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('item_category_id', 'DESC');
		return $this->db->get('inventory_item_category');
	}
	
	function fetch_all_active(){
		$this->db->order_by('item_category_id', 'DESC');
		$this->db->where('inventory_item_category.is_active_inv_item_cat', 1);
		return $this->db->get('inventory_item_category');
	}
	
	
	function insert($data)
	{
		$this->db->insert('inventory_item_category', $data);
	}

	function fetch_single($item_category_id)
	{
		$this->db->where('item_category_id', $item_category_id);
		$query = $this->db->get('inventory_item_category');
		return $query->result_array();
	}

	function update_single($item_category_id, $data)
	{
		$this->db->where('item_category_id', $item_category_id);
		$this->db->update('inventory_item_category', $data);
	}

	function delete_single($item_category_id)
	{
		$this->db->where('item_category_id', $item_category_id);
		$this->db->delete('inventory_item_category');
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
