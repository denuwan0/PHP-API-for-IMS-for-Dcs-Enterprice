<?php

class Customer_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('customer_id', 'ASC');
		return $this->db->get('customer');
	}
	
	function insert($data)
	{
		$this->db->insert('customer', $data);
	}

	function fetch_single($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		$query = $this->db->get('customer');
		return $query->result_array();
	}
	
	function fetch_single_by_mobile($customer_contact_no)
	{	
		$this->db->where('customer_contact_no', $customer_contact_no);
		$query = $this->db->get('customer');
		return $query->result_array();
	}
	
	function fetch_single_by_email($customer_email)
	{
		$this->db->where('customer_email', $customer_email);
		$query = $this->db->get('customer');
		return $query->result_array();
	}
	
	function fetch_single_by_nic($customer_old_nic_no)
	{
		$this->db->where('customer_old_nic_no', $customer_old_nic_no);
		$query = $this->db->get('customer');
		return $query->result_array();
	}

	function update_single($customer_id, $data)
	{
		$this->db->where('customer_id', $customer_id);
		$this->db->update('customer', $data);
	}

	function delete_single($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		$this->db->delete('customer');
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
		$this->db->from('customer');
		$query = $this->db->get();
		return $query;
	}
	
	function fetch_all_active(){
		$query = $this->db->get('customer');
		$this->db->where('is_active_customer', 1);
		return $query;
	}
}
