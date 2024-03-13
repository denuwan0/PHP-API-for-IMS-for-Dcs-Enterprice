<?php

class Inventory_rental_invoice_detail_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('rental_detail_id', 'DESC');
		return $this->db->get('inventory_rental_invoice_detail');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_rental_invoice_detail', $data);
	}

	function fetch_single($rental_detail_id)
	{
		$this->db->where('rental_detail_id', $rental_detail_id);
		$query = $this->db->get('inventory_rental_invoice_detail');
		return $query->result_array();
	}

	function update_single($rental_detail_id, $data)
	{
		$this->db->where('rental_detail_id', $rental_detail_id);
		$this->db->update('inventory_rental_invoice_detail', $data);
	}
	
	function fetch_all_by_item_id($item_id)
	{
		$this->db->where('item_id', $item_id);
		$query = $this->db->get('inventory_rental_invoice_detail');
		return $query;
	}

	function delete_single($rental_detail_id)
	{
		$this->db->where('rental_detail_id', $rental_detail_id);
		$this->db->delete('inventory_rental_invoice_detail');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_all_by_invoice_id($invoice_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_rental_invoice_detail');
		$this->db->join('inventory_item', 'inventory_item.item_id  = inventory_rental_invoice_detail.item_id ','left');
		$query = $this->db->where('inventory_rental_invoice_detail.invoice_id', $invoice_id);
		return $query = $this->db->get();
	}
}
