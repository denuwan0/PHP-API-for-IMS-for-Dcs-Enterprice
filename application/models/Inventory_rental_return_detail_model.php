<?php

class Inventory_rental_return_detail_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('item_id', 'ASC');
		return $this->db->get('inventory_rental_return_detail');
	}
	
	function fetch_all_active(){
		$this->db->order_by('item_id', 'ASC');
		$this->db->where('is_active_inv_item', 1);
		return $this->db->get('inventory_rental_return_detail');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_rental_return_detail', $data);
	}

	function fetch_single($item_id)
	{
		$this->db->where('item_id', $item_id);
		$query = $this->db->get('inventory_rental_return_detail');
		return $query->result_array();
	}
	
	function fetch_single_join($item_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_rental_return_detail');
		$this->db->join('inventory_rental_return_detail_category', 'inventory_rental_return_detail.item_category = inventory_rental_return_detail_category.item_category_id','left');
		$this->db->where('inventory_rental_return_detail.item_id', $item_id);
		
		return $query = $this->db->get();
	}

	function update_single($item_id, $data)
	{
		$this->db->where('item_id', $item_id);
		$this->db->update('inventory_rental_return_detail', $data);
	}

	function delete_single($item_id)
	{
		$this->db->where('item_id', $item_id);
		$this->db->delete('inventory_rental_return_detail');
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
