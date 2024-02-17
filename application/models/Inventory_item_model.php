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
	
	function fetch_all_active_items_by_category_id($id)
	{
		$query = $this->db->query("SELECT inventory_item.item_id AS item_id, inventory_item.item_name AS item_name, inventory_item.item_image_url AS image_url, 0 as is_sub_item FROM inventory_item WHERE inventory_item.item_category = $id AND inventory_item.is_active_inv_item = 1 UNION SELECT inventory_sub_item.sub_item_id AS item_id, inventory_sub_item.sub_item_name AS item_name, inventory_sub_item.sub_item_image_url AS image_url, 1 as is_sub_item FROM inventory_sub_item WHERE inventory_sub_item.sub_item_category = $id AND inventory_sub_item.is_active_inv_sub_item = 1 GROUP BY item_id, is_sub_item;");
		
		return $query->result_array();
	}
	
	
	
}
