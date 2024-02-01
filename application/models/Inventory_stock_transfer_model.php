<?php

class Inventory_stock_transfer_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('transfer_id', 'DESC');
		return $this->db->get('inventory_stock_transfer');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_stock_transfer', $data);
	}

	function fetch_single($transfer_id)
	{
		$this->db->where('transfer_id', $transfer_id);
		$query = $this->db->get('inventory_stock_transfer');
		return $query->result_array();
	}

	function update_single($transfer_id, $data)
	{
		$this->db->where('transfer_id', $transfer_id);
		$this->db->update('inventory_stock_transfer', $data);
	}

	function delete_single($transfer_id)
	{
		$this->db->where('transfer_id', $transfer_id);
		$this->db->delete('inventory_stock_transfer');
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
