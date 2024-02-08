<?php

class inventory_stock_rental_detail_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('rental_stock_id', 'ASC');
		return $this->db->get('inventory_stock_rental_detail');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_stock_rental_detail', $data);
		return $this->db->insert_id();
	}

	function fetch_single($rental_stock_id)
	{
		$this->db->where('rental_stock_id', $rental_stock_id);
		$query = $this->db->get('inventory_stock_rental_detail');
		return $query->result_array();
	}
	
	function fetch_all_by_branch_id($branch_id)
	{
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get('inventory_stock_rental_detail');
		return $query;
	}
	
	function fetch_all_by_item_id($item_id)
	{
		$this->db->where('item_id', $item_id);
		$query = $this->db->get('inventory_stock_rental_detail');
		return $query;
	}

	function update_single($rental_stock_id, $data)
	{
		$this->db->where('rental_stock_id', $rental_stock_id);
		$this->db->update('inventory_stock_rental_detail', $data);
	}
	
	function fetch_all_by_stock_batch_id($stock_batch_id)
	{
		$this->db->where('stock_batch_id', $stock_batch_id);
		$query = $this->db->get('inventory_stock_rental_detail');
		return $query;
	}

	function delete_single($rental_stock_id)
	{
		$this->db->where('rental_stock_id', $rental_stock_id);
		$this->db->delete('inventory_stock_rental_detail');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_all_active_by_rental_stock_header_id($rental_stock_header_id)
	{
		//var_dump($rental_stock_header_id);
		
		$query = $this->db->query("SELECT inventory_stock_rental_detail.rental_stock_id, inventory_stock_rental_detail.rental_stock_header_id, inventory_stock_rental_detail.item_id, inventory_stock_rental_detail.max_rent_price, inventory_stock_rental_detail.min_rent_price, inventory_stock_rental_detail.full_stock_count, inventory_stock_rental_detail.out_stock_count, inventory_stock_rental_detail.in_stock_count, inventory_stock_rental_detail.damage_stock_count, inventory_stock_rental_detail.repair_stock_count, inventory_stock_rental_detail.stock_re_order_level, inventory_stock_rental_detail.is_sub_item, IF(inventory_stock_rental_detail.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM `inventory_stock_rental_detail` left join inventory_item on inventory_stock_rental_detail.item_id = inventory_item.item_id left join inventory_sub_item on inventory_stock_rental_detail.item_id = inventory_sub_item.sub_item_id WHERE `rental_stock_header_id` = '$rental_stock_header_id' AND inventory_stock_rental_detail.is_active_rental_stock_detail = 1");
						
		//var_dump($query->result_array());
		return $query;
	}
}
