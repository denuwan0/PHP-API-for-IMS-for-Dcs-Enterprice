<?php

class Inventory_sub_item_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('sub_item_id', 'ASC');
		return $this->db->get('inventory_sub_item');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_sub_item', $data);
	}
	
	function fetch_all_active(){
		$this->db->order_by('sub_item_id', 'ASC');
		$this->db->where('is_active_inv_sub_item', 1);
		return $this->db->get('inventory_sub_item');
	}

	function fetch_single($sub_item_id)
	{
		$this->db->where('sub_item_id', $sub_item_id);
		$query = $this->db->get('inventory_sub_item');
		return $query->result_array();
	}

	function update_single($sub_item_id, $data)
	{
		$this->db->where('sub_item_id', $sub_item_id);
		$this->db->update('inventory_sub_item', $data);
	}
	
	function fetch_all_by_item_id($item_id)
	{
		$this->db->where('item_id', $item_id);
		$query = $this->db->get('inventory_sub_item');
		return $query;
	}

	function delete_single($sub_item_id)
	{
		$this->db->where('sub_item_id', $sub_item_id);
		$this->db->delete('inventory_sub_item');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_single_join_by_sub_item_id($sub_item_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_sub_item');
		$this->db->join('inventory_item', 'inventory_item.item_id = inventory_sub_item.sub_item_id','left');
		$this->db->where('inventory_sub_item.sub_item_id', $sub_item_id);
		
		return $query = $this->db->get();
	}
	
	
	
	
}
