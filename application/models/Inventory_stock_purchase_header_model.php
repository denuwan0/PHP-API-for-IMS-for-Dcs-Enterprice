<?php

class Inventory_stock_purchase_header_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('stock_batch_id ', 'ASC');
		return $this->db->get('inventory_stock_purchase_header');
	}
	
	function fetch_all_active(){
		$this->db->where('is_active_stock_purchase ', 1 );
		$this->db->where('is_approved_stock ', 1 );
		$this->db->where('is_allocated_stock ', 0 );
		return $this->db->get('inventory_stock_purchase_header');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_stock_purchase_header', $data);
		return $this->db->insert_id();
	}
	
	function update($data)
	{
		$this->db->insert('inventory_stock_purchase_header', $data);
		return $this->db->insert_id();
	}

	function fetch_single($stock_batch_id )
	{
		$this->db->where('stock_batch_id ', $stock_batch_id );
		$query = $this->db->get('inventory_stock_purchase_header');
		return $query->result_array();
	}

	function update_single($stock_batch_id , $data)
	{
		$this->db->where('stock_batch_id', $stock_batch_id );
		$this->db->update('inventory_stock_purchase_header', $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function delete_single($stock_batch_id )
	{
		$this->db->where('stock_batch_id ', $stock_batch_id );
		$this->db->delete('inventory_stock_purchase_header');
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
		$this->db->from('inventory_stock_purchase_header');
		$this->db->join('inventory_stock_purchase_detail', 'inventory_stock_purchase_header.stock_batch_id = inventory_stock_purchase_detail.stock_batch_id','left');
		$this->db->join('inventory_item', 'inventory_stock_purchase_detail.main_item_id = inventory_item.item_id','left');
		$this->db->join('inventory_sub_item', 'inventory_stock_purchase_detail.sub_item_id = inventory_sub_item.sub_item_id','left');
		//$this->db->group_by('inventory_item_with_sub_items.main_item_id', 'DESC');		
		return $query = $this->db->get();
	}
	
	function fetch_all_header()
	{
		$this->db->select('*');
		$this->db->from('inventory_stock_purchase_header');
		//$this->db->group_by('inventory_item_with_sub_items.main_item_id', 'DESC');
		return $query = $this->db->get();
	}
	
	function fetch_single_join($stock_batch_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_stock_purchase_header');
		$this->db->join('inventory_stock_purchase_detail', 'inventory_stock_purchase_header.stock_batch_id = inventory_stock_purchase_detail.stock_batch_id','left');
		//$this->db->group_by('inventory_item_with_sub_items.main_item_id', 'DESC');
		$this->db->where('inventory_stock_purchase_header.stock_batch_id ', $stock_batch_id );
		return $query = $this->db->get();
		//print_r($this->db->last_query());    
	}
	
}
