<?php

class Inventory_rental_invoice_header_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('invoice_id', 'DESC');
		return $this->db->get('inventory_rental_invoice_header');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_rental_invoice_header', $data);
		return $this->db->insert_id();
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
		$this->db->select('*');
		$this->db->from('inventory_rental_invoice_header');
		$this->db->join('company_branch', 'company_branch.company_branch_id = inventory_rental_invoice_header.branch_id','left');
		$this->db->join('emp_details', 'inventory_rental_invoice_header.emp_id = emp_details.emp_id','left');
		$this->db->join('customer', 'inventory_rental_invoice_header.customer_id = customer.customer_id','left');
		$query = $this->db->get();
		return $query;
	}
	
	function fetch_all_active_by_branch_id($branch_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_rental_invoice_header');
		$this->db->where('is_active_inv_rent_invoice_hdr', 1);
		$this->db->where('branch_id', $branch_id);
		$this->db->join('company_branch', 'company_branch.company_branch_id = inventory_rental_invoice_header.branch_id','left');
		$this->db->join('emp_details', 'inventory_rental_invoice_header.emp_id = emp_details.emp_id','left');
		$this->db->join('customer', 'inventory_rental_invoice_header.customer_id = customer.customer_id','left');
		$query = $this->db->get();
		return $query;
	}
	
	function fetch_all_active()
	{
		$this->db->select('*');
		$this->db->from('inventory_rental_invoice_header');
		$this->db->where('is_active_inv_rent_invoice_hdr', 1);
		$this->db->join('company_branch', 'company_branch.company_branch_id = inventory_rental_invoice_header.branch_id','left');
		$this->db->join('emp_details', 'inventory_rental_invoice_header.emp_id = emp_details.emp_id','left');
		$this->db->join('customer', 'inventory_rental_invoice_header.customer_id = customer.customer_id','left');
		$query = $this->db->get();
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
	
	function fetch_all_by_branch_id_invoice_id($branch_id, $invoice_id)
	{
		$this->db->where('branch_id', $branch_id);
		$this->db->where('invoice_id', $invoice_id);
		$query = $this->db->get('inventory_rental_invoice_header');
		//echo $this->db->last_query();
		return $query;
	}
	
}
