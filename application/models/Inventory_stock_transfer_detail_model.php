<?php

class Inventory_stock_transfer_detail_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('transfer_id', 'ASC');
		return $this->db->get('inventory_stock_transfer_detail');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_stock_transfer_detail', $data);
	}

	function fetch_single($transfer_id)
	{
		$this->db->where('inventory_stock_transfer_header_id', $transfer_id);
		$query = $this->db->get('inventory_stock_transfer_detail');
		return $query->result_array();
	}

	function update_single($transfer_id, $data)
	{
		$this->db->where('transfer_id', $transfer_id);
		$this->db->update('inventory_stock_transfer_detail', $data);
	}

	function delete_single($transfer_id)
	{
		$this->db->where('transfer_id', $transfer_id);
		$this->db->delete('inventory_stock_transfer_detail');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
			
	function fetch_single_join($transfer_id)
	{
		$this->db->select('inventory_stock_transfer_detail.inventory_stock_transfer_detail_id, inventory_stock_transfer_detail.inventory_stock_transfer_header_id, inventory_stock_transfer_detail.item_id, inventory_stock_transfer_detail.is_sub_item, IF(inventory_stock_transfer_detail.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name, inventory_stock_transfer_detail.no_of_items, inventory_stock_transfer_detail.is_active_stock_transfer_detail,
		inventory_sub_item.sub_item_id, inventory_sub_item.sub_item_name, inventory_sub_item.sub_item_image_url, inventory_sub_item.sub_item_category, inventory_sub_item.is_active_inv_sub_item, inventory_item.item_id, inventory_item.item_name,
		inventory_item.item_image_url, inventory_item.item_type, inventory_item.item_category, inventory_item.is_active_inv_item, inventory_item.is_feature, inventory_item.is_web_pattern');
		$this->db->from('inventory_stock_transfer_detail');
		$this->db->join('inventory_item', 'inventory_item.item_id = inventory_stock_transfer_detail.item_id','left');
		$this->db->join('inventory_sub_item', 'inventory_sub_item.sub_item_id = inventory_stock_transfer_detail.item_id','left');
		$this->db->where('inventory_stock_transfer_detail.inventory_stock_transfer_header_id', $transfer_id);
		$query = $this->db->get();
		//var_dump($this->db->last_query());
		return $query->result_array();
	}
	
	function delete_all_items_by_header_id($transfer_id)
	{
		$this->db->where('inventory_stock_transfer_header_id', $transfer_id);
		$query = $this->db->get('inventory_stock_transfer_detail');
		return $query;
	}
	
	function count_items_by_batch_id($transfer_id )
	{
		$this->db->where('inventory_stock_transfer_header_id ', $transfer_id );
		$query = $this->db->get('inventory_stock_transfer_detail');
		return $this->db->affected_rows();
	}
	
}
