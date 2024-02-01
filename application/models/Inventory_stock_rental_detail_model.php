<?php

class inventory_stock_rental_detail_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('rental_stock_id', 'DESC');
		return $this->db->get('inventory_stock_rental_detail');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_stock_rental_detail', $data);
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
	
}
