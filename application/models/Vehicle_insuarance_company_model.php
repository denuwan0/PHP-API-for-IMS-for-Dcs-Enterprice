<?php

class Vehicle_insuarance_company_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('insuar_comp_id', 'ASC');
		return $this->db->get('vehicle_insuarance_company');
	}
	
	function fetch_all_active(){
		$this->db->order_by('insuar_comp_id', 'ASC');
		$this->db->where('is_active_ins_comp', 1);
		return $this->db->get('vehicle_insuarance_company');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_insuarance_company', $data);
	}

	function fetch_single($insuar_comp_id)
	{
		$this->db->where('insuar_comp_id', $insuar_comp_id);
		$query = $this->db->get('vehicle_insuarance_company');
		return $query->result_array();
	}

	function update_single($insuar_comp_id, $data)
	{
		$this->db->where('insuar_comp_id', $insuar_comp_id);
		$this->db->update('vehicle_insuarance_company', $data);
	}

	function delete_single($insuar_comp_id)
	{
		$this->db->where('insuar_comp_id', $insuar_comp_id);
		$this->db->delete('vehicle_insuarance_company');
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
