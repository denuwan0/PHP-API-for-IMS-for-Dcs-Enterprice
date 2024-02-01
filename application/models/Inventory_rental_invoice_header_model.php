<?php

class Inventory_rental_invoice_header_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('invoice_id', 'DESC');
		return $this->db->get('inventory_rental_invoice_header');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_rental_invoice_header', $data);
	}

	function fetch_single($invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id);
		$query = $this->db->get('inventory_rental_invoice_header');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('inventory_rental_invoice_header');
		return $query;
	}

	function update_single($invoice_id, $data)
	{
		$this->db->where('invoice_id', $invoice_id);
		$this->db->update('inventory_rental_invoice_header', $data);
	}
	
	function fetch_all_by_branch_id($branch_id)
	{
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get('inventory_rental_invoice_header');
		return $query;
	}

	function delete_single($invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('inventory_rental_invoice_header');
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
