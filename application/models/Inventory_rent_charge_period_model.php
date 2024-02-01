<?php

class Inventory_rent_charge_period_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('period_id', 'DESC');
		return $this->db->get('inventory_rent_charge_period');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_rent_charge_period', $data);
	}

	function fetch_single($period_id)
	{
		$this->db->where('period_id', $period_id);
		$query = $this->db->get('inventory_rent_charge_period');
		return $query->result_array();
	}

	function update_single($period_id, $data)
	{
		$this->db->where('period_id', $period_id);
		$this->db->update('inventory_rent_charge_period', $data);
	}

	function delete_single($period_id)
	{
		$this->db->where('period_id', $period_id);
		$this->db->delete('inventory_rent_charge_period');
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
