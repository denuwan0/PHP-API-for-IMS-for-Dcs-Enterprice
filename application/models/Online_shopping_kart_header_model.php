<?php

class Online_shopping_kart_header_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('invoice_id', 'DESC');
		return $this->db->get('online_shopping_kart_header');
	}
	
	function insert($data)
	{
		$this->db->insert('online_shopping_kart_header', $data);
		return $this->db->insert_id();
	}

	function fetch_single($invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id);
		$query = $this->db->get('online_shopping_kart_header');
		return $query->result_array();
	}

	function update_single($invoice_id, $data)
	{
		$this->db->where('invoice_id', $invoice_id);
		$this->db->update('online_shopping_kart_header', $data);
	}

	function delete_single($invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('online_shopping_kart_header');
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
