<?php

class Inventory_item_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('item_id', 'ASC');
		return $this->db->get('inventory_item');
	}
	
	function fetch_all_active(){
		$this->db->order_by('item_id', 'ASC');
		$this->db->where('is_active_inv_item', 1);
		return $this->db->get('inventory_item');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_item', $data);
	}

	function fetch_single($item_id)
	{
		$this->db->where('item_id', $item_id);
		$query = $this->db->get('inventory_item');
		return $query->result_array();
	}
	
	function fetch_single_join($item_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_item');
		$this->db->join('inventory_item_category', 'inventory_item.item_category = inventory_item_category.item_category_id','left');
		$this->db->where('inventory_item.item_id', $item_id);
		
		return $query = $this->db->get();
	}

	function update_single($item_id, $data)
	{
		$this->db->where('item_id', $item_id);
		$this->db->update('inventory_item', $data);
	}

	function delete_single($item_id)
	{
		$this->db->where('item_id', $item_id);
		$this->db->delete('inventory_item');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('inventory_item');
		$this->db->join('inventory_item_category', 'inventory_item.item_category = inventory_item_category.item_category_id','left');
		//$this->db->where('company.company_id', $company_id);
		return $query = $this->db->get();
	}
	
}
