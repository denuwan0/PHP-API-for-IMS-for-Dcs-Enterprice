<?php

class Inventory_retail_invoice_header_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('invoice_id', 'ASC');
		return $this->db->get('inventory_retail_invoice_header');
	}
	
	function fetch_all_active(){
		$this->db->join('company_branch', 'company_branch.company_branch_id   = inventory_retail_invoice_header.branch_id ','left');
		$this->db->join('customer', 'customer.customer_id    = inventory_retail_invoice_header.customer_id ','left');
		$this->db->where('inventory_retail_invoice_header.is_active_inv_retail_invoice_hdr', 1);
		$query = $this->db->get('inventory_retail_invoice_header');
		return $query;
	}
	
	function fetch_all_active_by_branch_id($branch_id){
		$this->db->join('company_branch', 'company_branch.company_branch_id   = inventory_retail_invoice_header.branch_id ','left');
		$this->db->join('customer', 'customer.customer_id    = inventory_retail_invoice_header.customer_id ','left');
		$this->db->where('branch_id', $branch_id);	
		$this->db->where('inventory_retail_invoice_header.is_active_inv_retail_invoice_hdr', 1);
		$query = $this->db->get('inventory_retail_invoice_header');
		return $query;
	}
	
	function fetch_all_active_not_complete(){
		$this->db->join('company_branch', 'company_branch.company_branch_id   = inventory_retail_invoice_header.branch_id ','left');
		$this->db->join('customer', 'customer.customer_id    = inventory_retail_invoice_header.customer_id ','left');
		$this->db->where('inventory_retail_invoice_header.is_active_inv_retail_invoice_hdr', 1);
		$this->db->where('inventory_retail_invoice_header.is_complete', 0);
		$query = $this->db->get('inventory_retail_invoice_header');
		return $query;
	}
	
	function fetch_all_active_by_branch_id_not_complete($branch_id){
		$this->db->join('company_branch', 'company_branch.company_branch_id   = inventory_retail_invoice_header.branch_id ','left');
		$this->db->join('customer', 'customer.customer_id    = inventory_retail_invoice_header.customer_id ','left');
		$this->db->where('branch_id', $branch_id);	
		$this->db->where('inventory_retail_invoice_header.is_active_inv_retail_invoice_hdr', 1);
				$this->db->where('inventory_retail_invoice_header.is_complete', 0);
		$query = $this->db->get('inventory_retail_invoice_header');
		return $query;
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_retail_invoice_header', $data);
		return $this->db->insert_id();
	}

	function fetch_single($invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id);
		$query = $this->db->get('inventory_retail_invoice_header');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('inventory_retail_invoice_header');
		return $query;
	}
	
	function fetch_all_by_branch_id($branch_id)
	{
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get('inventory_retail_invoice_header');
		return $query;
	}
	
	function fetch_all_by_branch_id_invoice_id($branch_id, $invoice_id)
	{
		$this->db->where('branch_id', $branch_id);
		$this->db->where('invoice_id', $invoice_id);
		$query = $this->db->get('inventory_retail_invoice_header');
		return $query;
	}

	function update_single($invoice_id, $data)
	{
		$this->db->where('invoice_id', $invoice_id);
		$this->db->update('inventory_retail_invoice_header', $data);
	}

	function delete_single($invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('inventory_retail_invoice_header');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_single_by_invoice_id($invoice_id)
	{
		$this->db->where('inventory_retail_invoice_header.invoice_id', $invoice_id);
		$this->db->join('inventory_retail_invoice_detail', 'inventory_retail_invoice_detail.invoice_id  = inventory_retail_invoice_header.invoice_id ','left');
		$query = $this->db->get('inventory_retail_invoice_header');
		return $query;
	}
	
	function fetch_invoice_header_by_invoice_id($invoice_id)
	{
		$this->db->where('inventory_retail_invoice_header.invoice_id', $invoice_id);
		$this->db->join('customer', 'customer.customer_id    = inventory_retail_invoice_header.customer_id   ','left');
		$query = $this->db->get('inventory_retail_invoice_header');
		return $query;
	}
	
	function fetch_invoice_detail_by_invoice_id($invoice_id)
	{
		$this->db->where('inventory_retail_invoice_detail.invoice_id', $invoice_id);
		$this->db->join('inventory_item', 'inventory_item.item_id   = inventory_retail_invoice_detail.item_id  ','left');
		$query = $this->db->get('inventory_retail_invoice_detail');
		return $query;
	}
}
