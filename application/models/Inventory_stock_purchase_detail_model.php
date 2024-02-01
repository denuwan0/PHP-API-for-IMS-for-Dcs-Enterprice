<?php

class Inventory_stock_purchase_detail_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('stock_batch_id ', 'ASC');
		return $this->db->get('inventory_stock_purchase_detail');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_stock_purchase_detail', $data);
	}

	function fetch_single($stock_batch_id)
	{
		$this->db->where('stock_batch_id ', $stock_batch_id );
		$query = $this->db->get('inventory_stock_purchase_detail');
		return $query->result_array();
	}
	
	function fetch_single_by_main_item_id($stock_batch_id, $main_item_id)
	{
		$this->db->where('stock_batch_id', $stock_batch_id );
		$this->db->where('item_id', $main_item_id );
		$this->db->where('is_sub_item', 0 );
		$query = $this->db->get('inventory_stock_purchase_detail');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_single_by_sub_item_id($stock_batch_id, $sub_item_id)
	{
		$this->db->where('stock_batch_id', $stock_batch_id );
		$this->db->where('item_id', $main_item_id );
		$this->db->where('is_sub_item', 1 );
		$query = $this->db->get('inventory_stock_purchase_detail');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_sum_of_available_items($stock_batch_id)
	{
		$this->db->select_sum('available_no_of_items');		
		$this->db->where('stock_batch_id', $stock_batch_id );
		$query = $this->db->get('inventory_stock_purchase_detail');
		return $query->result_array();
	}
	
	function fetch_available_no_of_items_by_main_and_sub_item_id_item_type($stock_batch_id, $item_id, $item_type)
	{
		$this->db->select('available_no_of_items');
		$this->db->where('stock_batch_id', $stock_batch_id );
		$this->db->where('item_id', $item_id );
		$this->db->where('is_sub_item', $item_type );
		$query = $this->db->get('inventory_stock_purchase_detail');
		return $query->result_array();
	}

	function update_single_main_item($stock_batch_id ,$main_item_id, $data)
	{
		$this->db->where('stock_batch_id', $stock_batch_id );
		$this->db->where('item_id', $main_item_id );
		$this->db->where('is_sub_item', 0 );
		$this->db->replace('inventory_stock_purchase_detail', $data);
	}
	
	function update_single_sub_item($stock_batch_id ,$sub_item_id, $data)
	{
		$this->db->where('stock_batch_id', $stock_batch_id );
		$this->db->where('item_id', $main_item_id );
		$this->db->where('is_sub_item', 1 );
		$this->db->replace('inventory_stock_purchase_detail', $data);
	}
	
	function update_single_main_and_sub_item_with_item_type($stock_batch_id, $item_id, $is_sub_item, $itemData)
	{
		$this->db->where('stock_batch_id', $stock_batch_id );
		$this->db->where('item_id', $item_id );
		$this->db->where('is_sub_item', $is_sub_item );
		$this->db->update('inventory_stock_purchase_detail', $itemData);
	}
	
	function count_items_by_batch_id($stock_batch_id )
	{
		$this->db->where('stock_batch_id ', $stock_batch_id );
		$query = $this->db->get('inventory_stock_purchase_detail');
		return $this->db->affected_rows();
	}

	function delete_single($stock_batch_id, $item_id )
	{
		$this->db->where('stock_batch_id', $stock_batch_id );
		$this->db->where('item_id', $item_id );
		$this->db->delete('inventory_stock_purchase_detail');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function delete_all_items_by_stock_batch_id($stock_batch_id )
	{
		$this->db->where('stock_batch_id', $stock_batch_id );
		$this->db->delete('inventory_stock_purchase_detail');
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
		$this->db->from('inventory_stock_purchase_detail');
		$this->db->join('inventory_item', 'inventory_stock_purchase.main_item_id = inventory_item.item_id','left');
		$this->db->join('inventory_sub_item', 'inventory_stock_purchase.sub_item_id = inventory_sub_item.sub_item_id','left');
		//$this->db->group_by('inventory_item_with_sub_items.main_item_id', 'DESC');
		return $query = $this->db->get();
	}
	
	
	
	function fetch_single_join($id)
	{
		$query = $this->db->query("SELECT inventory_stock_purchase_detail.purchase_detail_line_id, inventory_stock_purchase_detail.stock_batch_id, inventory_stock_purchase_detail.item_id, inventory_stock_purchase_detail.item_cost, inventory_stock_purchase_detail.no_of_items, inventory_stock_purchase_detail.allocated_no_of_items, inventory_stock_purchase_detail.available_no_of_items, inventory_stock_purchase_detail.is_sub_item, IF(inventory_stock_purchase_detail.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM inventory_stock_purchase_detail left join inventory_item on inventory_stock_purchase_detail.item_id = inventory_item.item_id left join inventory_sub_item on inventory_stock_purchase_detail.item_id = inventory_sub_item.sub_item_id WHERE stock_batch_id = '$id' ");
		
		return $query->result_array();
	}
	
	function fetch_all_active_details_by_batch_id($id)
	{
		$this->db->select('*');
		$this->db->from('inventory_stock_purchase_detail');
		$this->db->where('inventory_stock_purchase_detail.stock_batch_id ', $id);
		$this->db->where('inventory_stock_purchase_detail.available_no_of_items >', 0);
		$this->db->join('inventory_item', 'inventory_stock_purchase_detail.item_id = inventory_item.item_id','left');
		$this->db->join('inventory_sub_item', 'inventory_stock_purchase_detail.item_id = inventory_sub_item.sub_item_id','left');
		$query = $this->db->get();
		return $query->result_array();
	}
	
}
