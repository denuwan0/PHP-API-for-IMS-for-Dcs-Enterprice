<?php

class vehicle_insuarance_claim_details_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('claim_id', 'ASC');
		return $this->db->get('vehicle_insuarance_claim_details');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_insuarance_claim_details', $data);
	}

	function fetch_single($claim_id)
	{
		$this->db->where('claim_id', $claim_id);
		$query = $this->db->get('vehicle_insuarance_claim_details');
		return $query->result_array();
	}
	
	function fetch_all_by_repair_id($repair_id)
	{
		$this->db->where('repair_id', $repair_id);
		$query = $this->db->get('vehicle_insuarance_claim_details');
		return $query;
	}

	function update_single($claim_id, $data)
	{
		$this->db->where('claim_id', $claim_id);
		$this->db->update('vehicle_insuarance_claim_details', $data);
	}

	function delete_single($claim_id)
	{
		$this->db->where('claim_id', $claim_id);
		$this->db->delete('vehicle_insuarance_claim_details');
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
		$this->db->from('vehicle_insuarance_claim_details');	
		$this->db->join('vehicle_repair', 'vehicle_insuarance_claim_details.repair_id = vehicle_repair.repair_id','left');
		$this->db->join('vehicle_details', 'vehicle_details.vehicle_id  = vehicle_repair.vehicle_id','left');		
		$query = $this->db->get();	
		return $query;
		
	}
	
	function fetch_single_join($claim_id)
	{	
		$this->db->select('*');
		$this->db->from('vehicle_insuarance_claim_details');	
		$this->db->join('vehicle_repair', 'vehicle_insuarance_claim_details.repair_id = vehicle_repair.repair_id','left');
		$this->db->join('vehicle_details', 'vehicle_details.vehicle_id  = vehicle_repair.vehicle_id','left');
		$this->db->where('claim_id', $claim_id);
		$query = $this->db->get();	
		return $query;
		
	}
}
