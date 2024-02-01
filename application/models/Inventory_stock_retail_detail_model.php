<?php

class Inventory_stock_retail_detail_model extends CI_Model{   
    
	function fetch_all(){
		return $this->db->get('inventory_stock_retail_detail');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_stock_retail_detail', $data);
		return $this->db->insert_id();
	}

	function fetch_single($retail_stock_detail_id)
	{
		$this->db->where('retail_stock_detail_id', $retail_stock_detail_id);
		$query = $this->db->get('inventory_stock_retail_detail');
		return $query->result_array();
	}
	
	function fetch_all_by_item_id($item_id)
	{
		$this->db->where('item_id', $item_id);
		$query = $this->db->get('inventory_stock_retail_detail');
		return $query;
	}
	
	function fetch_all_by_retail_stock_header_id($retail_stock_header_id)
	{
		//var_dump($retail_stock_header_id);
		
		$query = $this->db->query("SELECT inventory_stock_retail_detail.retail_stock_detail_id, inventory_stock_retail_detail.retail_stock_header_id, inventory_stock_retail_detail.item_id, inventory_stock_retail_detail.max_sale_price, inventory_stock_retail_detail.min_sale_price, inventory_stock_retail_detail.full_stock_count, inventory_stock_retail_detail.stock_re_order_level, inventory_stock_retail_detail.is_sub_item, IF(inventory_stock_retail_detail.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM `inventory_stock_retail_detail` join inventory_item on inventory_stock_retail_detail.item_id = inventory_item.item_id join inventory_sub_item on inventory_stock_retail_detail.item_id = inventory_sub_item.sub_item_id WHERE `retail_stock_header_id` = '$retail_stock_header_id'");
				
		//var_dump($query->result_array());
		return $query;
	}
	
	function fetch_all_active_by_retail_stock_header_id($retail_stock_header_id)
	{
		//var_dump($retail_stock_header_id);
		
		$query = $this->db->query("SELECT inventory_stock_retail_detail.retail_stock_detail_id, inventory_stock_retail_detail.retail_stock_header_id, inventory_stock_retail_detail.item_id, inventory_stock_retail_detail.max_sale_price, inventory_stock_retail_detail.min_sale_price, inventory_stock_retail_detail.full_stock_count, inventory_stock_retail_detail.stock_re_order_level, inventory_stock_retail_detail.is_sub_item, IF(inventory_stock_retail_detail.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM `inventory_stock_retail_detail` left join inventory_item on inventory_stock_retail_detail.item_id = inventory_item.item_id left join inventory_sub_item on inventory_stock_retail_detail.item_id = inventory_sub_item.sub_item_id WHERE `retail_stock_header_id` = '$retail_stock_header_id' AND inventory_stock_retail_detail.is_active_retail_stock_detail = 1");
		
		/* $this->db->where('retail_stock_header_id', $retail_stock_header_id);
		$this->db->where('is_active_retail_stock_detail', 1);
		$this->db->join('inventory_item', 'inventory_stock_retail_detail.item_id = inventory_item.item_id','left');
		$query = $this->db->get('inventory_stock_retail_detail'); */
				
		//var_dump($query->result_array());
		return $query;
	}
	
	function update_single($retail_stock_header_id, $retail_stock_detail_id, $data)
	{
		$this->db->where('retail_stock_header_id', $retail_stock_header_id);
		$this->db->where('retail_stock_detail_id', $retail_stock_detail_id);
		$this->db->update('inventory_stock_retail_detail', $data);
	}
	
	function inactive_single($retail_stock_detail_id, $data)
	{
		$this->db->where('retail_stock_detail_id', $retail_stock_detail_id);
		$query = $this->db->update('inventory_stock_retail_detail', $data);
		return $query;
	}
	
	function fetch_all_by_stock_batch_id($stock_batch_id)
	{
		$this->db->where('stock_batch_id', $stock_batch_id);
		$query = $this->db->get('inventory_stock_retail_detail');
		return $query;
	}
	

	function delete_single($stock_retail)
	{
		$this->db->where('stock_retail', $stock_retail);
		$this->db->delete('inventory_stock_retail_detail');
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
