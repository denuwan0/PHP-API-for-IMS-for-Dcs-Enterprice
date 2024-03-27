<?php

class Order_payment_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('payment_id', 'DESC');
		return $this->db->get('order_payments');
	}
	
	function insert($data)
	{
		$this->db->insert('order_payments', $data);
	}

	function fetch_single($payment_id)
	{
		$this->db->where('payment_id', $payment_id);
		$query = $this->db->get('order_payments');
		return $query->result_array();
	}

	function update_single($payment_id, $data)
	{
		$this->db->where('payment_id', $payment_id);
		$this->db->update('order_payments', $data);
	}

	function delete_single($payment_id)
	{
		$this->db->where('payment_id', $payment_id);
		$this->db->delete('order_payments');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_latest_payment_by_retail_invoice_id($invoice_id)
	{
		$query = $this->db->query("SELECT * FROM `order_payments` WHERE `order_id` = '$invoice_id' AND `is_retail_order` = 1 AND `is_complete` = 1 ORDER BY `payment_id` DESC LIMIT 1;");
		
		return $query;
	}
	
	function fetch_latest_payment_by_rental_invoice_id($invoice_id)
	{
		$query = $this->db->query("SELECT * FROM `order_payments` WHERE `order_id` = '$invoice_id' AND `is_rental_order` = 1 AND `is_complete` = 1 ORDER BY `payment_id` DESC LIMIT 1;");
		
		return $query;
	}
	
}
