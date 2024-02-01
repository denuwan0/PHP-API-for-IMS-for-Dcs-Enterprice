<?php

class Inventory_item_with_sub_items_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('line_id', 'DESC');
		return $this->db->get('inventory_item_with_sub_items');
	}
	
	function fetch_all_active(){
		$this->db->order_by('item_id', 'DESC');
		$this->db->where('is_active_inv_item', 1);
		return $this->db->get('inventory_item');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_item_with_sub_items', $data);
	}

	function fetch_single($sub_item_id)
	{
		$this->db->where('sub_item_id', $sub_item_id);
		$query = $this->db->get('inventory_item_with_sub_items');
		return $query->result_array();
	}

	function fetch_single_join($main_item_id)
	{
		$this->db->where('main_item_id', $main_item_id);
		$query = $this->db->get('inventory_item_with_sub_items');
		return $query->result_array();
	}

	function update_single($line_id, $data)
	{
		$this->db->where('line_id', $line_id);
		$this->db->update('inventory_item_with_sub_items', $data);
	}
	
	function fetch_all_by_item_id($item_id)
	{
		$this->db->where('main_item_id', $item_id);
		$query = $this->db->get('inventory_item_with_sub_items');
		return $query;
	}
	
	function fetch_all_by_line_id($line_id)
	{
		$this->db->where('line_id', $line_id);
		$query = $this->db->get('inventory_item_with_sub_items');
		return $query;
	}

	function delete_single($sub_item_id)
	{
		$this->db->where('sub_item_id', $sub_item_id);
		$this->db->delete('inventory_item_with_sub_items');
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
		$this->db->from('inventory_item_with_sub_items');
		$this->db->join('inventory_item', 'inventory_item.item_id = inventory_item_with_sub_items.sub_item_id','left');
		$this->db->where('inventory_item_with_sub_items.sub_item_id', $sub_item_id);
		
		return $query = $this->db->get();
	}
	
	function fetch_all_by_sub_item_id($sub_item_id)
	{
		$this->db->where('sub_item_id', $sub_item_id);
		$query = $this->db->get('inventory_item_with_sub_items');
		return $query;
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('inventory_item_with_sub_items');
		$this->db->join('inventory_item', 'inventory_item_with_sub_items.main_item_id = inventory_item.item_id','left');
		$this->db->join('inventory_sub_item', 'inventory_item_with_sub_items.sub_item_id = inventory_sub_item.sub_item_id','left');
		//$this->db->where('company.company_id', $company_id);
		$this->db->group_by('inventory_item_with_sub_items.main_item_id', 'DESC');
		return $query = $this->db->get();
	}
}
