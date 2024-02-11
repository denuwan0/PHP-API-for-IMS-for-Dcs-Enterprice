<?php

class Inventory_retail_total_stock_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('retail_stock_id', 'ASC');
		return $this->db->get('inventory_retail_total_stock');
	}
	
	function fetch_all_active(){
		$this->db->order_by('retail_stock_id', 'ASC');
		$this->db->where('is_active_retail_stock', 1);
		return $this->db->get('inventory_retail_total_stock');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_retail_total_stock', $data);
	}

	function fetch_single($retail_stock_id)
	{
		$this->db->where('retail_stock_id', $retail_stock_id);
		$query = $this->db->get('inventory_retail_total_stock');
		return $query->result_array();
	}
	
	function fetch_single_by_branch_id_item_id_is_sub($item_id, $branch_id, $is_sub_item)
	{
		$this->db->where('item_id', $item_id);
		$this->db->where('is_sub_item', $is_sub_item);
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get('inventory_retail_total_stock');
		return $query->result_array();
	}
	
	function fetch_single_join($retail_stock_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_retail_total_stock');
		$this->db->join('inventory_retail_total_stock_category', 'inventory_retail_total_stock.item_category = inventory_retail_total_stock_category.item_category_id','left');
		$this->db->where('inventory_retail_total_stock.retail_stock_id', $retail_stock_id);
		
		return $query = $this->db->get();
	}

	function update_single($retail_stock_id, $data)
	{
		$this->db->where('retail_stock_id', $retail_stock_id);
		$this->db->update('inventory_retail_total_stock', $data);
	}

	function delete_single($retail_stock_id)
	{
		$this->db->where('retail_stock_id', $retail_stock_id);
		$this->db->delete('inventory_retail_total_stock');
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
		$this->db->from('inventory_retail_total_stock');
		$this->db->join('inventory_retail_total_stock_category', 'inventory_retail_total_stock.item_category = inventory_retail_total_stock_category.item_category_id','left');
		//$this->db->where('company.company_id', $company_id);
		return $query = $this->db->get();
	}
	
}
