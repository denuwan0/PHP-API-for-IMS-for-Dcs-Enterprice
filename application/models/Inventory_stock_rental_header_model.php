<?php

class inventory_stock_rental_header_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('stock_rental_header_id', 'ASC');
		return $this->db->get('inventory_stock_rental_header');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_stock_rental_header', $data);
		return $this->db->insert_id();
	}

	function fetch_single($stock_rental_header_id)
	{
		$this->db->where('stock_rental_header_id', $stock_rental_header_id);
		$query = $this->db->get('inventory_stock_rental_header');
		return $query->result_array();
	}
	
	function fetch_all_by_branch_id($branch_id)
	{
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get('inventory_stock_rental_header');
		return $query;
	}

	function update_single($stock_rental_header_id, $data)
	{
		$this->db->where('stock_rental_header_id', $stock_rental_header_id);
		$this->db->update('inventory_stock_rental_header', $data);
	}
	
	function fetch_all_by_stock_batch_id($stock_batch_id)
	{
		$this->db->where('stock_batch_id', $stock_batch_id);
		$query = $this->db->get('inventory_stock_rental_header');
		return $query;
	}

	function delete_single($stock_rental_header_id)
	{
		$this->db->where('stock_rental_header_id', $stock_rental_header_id);
		$this->db->delete('inventory_stock_rental_header');
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
