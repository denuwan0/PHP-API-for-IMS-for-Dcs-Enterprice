<?php

class Online_order_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('order_id', 'DESC');
		return $this->db->get('online_order');
	}
	
	function insert($data)
	{
		$this->db->insert('online_order', $data);
	}

	function fetch_single($order_id)
	{
		$this->db->where('order_id', $order_id);
		$query = $this->db->get('online_order');
		return $query->result_array();
	}

	function update_single($order_id, $data)
	{
		$this->db->where('order_id', $order_id);
		$this->db->update('online_order', $data);
	}

	function delete_single($order_id)
	{
		$this->db->where('order_id', $order_id);
		$this->db->delete('online_order');
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
