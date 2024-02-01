<?php

class Inventory_invoice_hdr_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('rental_invoice_id', 'DESC');
		return $this->db->get('inventory_invoice_hdr');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_invoice_hdr', $data);
	}

	function fetch_single($rental_invoice_id)
	{
		$this->db->where('rental_invoice_id', $rental_invoice_id);
		$query = $this->db->get('inventory_invoice_hdr');
		return $query->result_array();
	}
	
	function fetch_all_by_branch_id($branch_id)
	{
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get('inventory_invoice_hdr');
		return $query;
	}

	function update_single($rental_invoice_id, $data)
	{
		$this->db->where('rental_invoice_id', $rental_invoice_id);
		$this->db->update('inventory_invoice_hdr', $data);
	}

	function delete_single($rental_invoice_id)
	{
		$this->db->where('rental_invoice_id', $rental_invoice_id);
		$this->db->delete('inventory_invoice_hdr');
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
