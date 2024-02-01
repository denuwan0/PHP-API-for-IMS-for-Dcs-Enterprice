<?php

class Inventory_item_sub_category_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('item_sub_cat_id', 'DESC');
		return $this->db->get('inventory_item_sub_category');
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('inventory_item_sub_category');
		$this->db->join('inventory_item_category', 'inventory_item_sub_category.item_category_id = inventory_item_category.item_category_id','left');
		//$this->db->where('company.company_id', $company_id);
		return $query = $this->db->get();
	}
	
	function fetch_single_join($item_sub_cat_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_item_sub_category');
		$this->db->join('inventory_item_category', 'inventory_item_sub_category.item_category_id = inventory_item_category.item_category_id','left');
		$this->db->where('inventory_item_sub_category.item_sub_cat_id ', $item_sub_cat_id );
		$query = $this->db->get();
		return $query->result_array();	
	}
	
	function fetch_all_by_item_category_id($item_category_id)
	{
		$this->db->where('item_category_id', $item_category_id);
		$query = $this->db->get('inventory_item_sub_category');
		return $query;
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_item_sub_category', $data);
	}

	function fetch_single($item_sub_cat_id)
	{
		$this->db->where('item_sub_cat_id', $item_sub_cat_id);
		$query = $this->db->get('inventory_item_sub_category');
		return $query->result_array();
	}

	function update_single($item_sub_cat_id, $data)
	{
		$this->db->where('item_sub_cat_id', $item_sub_cat_id);
		$this->db->update('inventory_item_sub_category', $data);
	}

	function delete_single($item_sub_cat_id)
	{
		$this->db->where('item_sub_cat_id', $item_sub_cat_id);
		$this->db->delete('inventory_item_sub_category');
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
