<?php

class Inventory_rental_total_stock_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('rental_stock_id', 'ASC');
		return $this->db->get('inventory_rental_total_stock');
	}
	
	function fetch_all_active(){
		$this->db->order_by('rental_stock_id', 'ASC');
		$this->db->where('is_active_rental_stock', 1);
		return $this->db->get('inventory_rental_total_stock');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_rental_total_stock', $data);
	}

	function fetch_single($rental_stock_id)
	{
		$this->db->where('rental_stock_id', $rental_stock_id);
		$query = $this->db->get('inventory_rental_total_stock');
		return $query->result_array();
	}
	
	function fetch_single_join($rental_stock_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_rental_total_stock');
		$this->db->join('inventory_rental_total_stock_category', 'inventory_rental_total_stock.item_category = inventory_rental_total_stock_category.item_category_id','left');
		$this->db->where('inventory_rental_total_stock.rental_stock_id', $rental_stock_id);
		
		return $query = $this->db->get();
	}

	function update_single($rental_stock_id, $data)
	{
		$this->db->where('rental_stock_id', $rental_stock_id);
		$this->db->update('inventory_rental_total_stock', $data);
	}

	function delete_single($rental_stock_id)
	{
		$this->db->where('rental_stock_id', $rental_stock_id);
		$this->db->delete('inventory_rental_total_stock');
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
		$this->db->from('inventory_rental_total_stock');
		$this->db->join('inventory_rental_total_stock_category', 'inventory_rental_total_stock.item_category = inventory_rental_total_stock_category.item_category_id','left');
		//$this->db->where('company.company_id', $company_id);
		return $query = $this->db->get();
	}
	
}
