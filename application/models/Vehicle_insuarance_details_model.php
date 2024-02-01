<?php

class Vehicle_insuarance_details_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('insuar_detail_id', 'DESC');
		return $this->db->get('vehicle_insuarance_details');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_insuarance_details', $data);
	}

	function fetch_single($insuar_detail_id)
	{
		$this->db->where('insuar_detail_id', $insuar_detail_id);
		$query = $this->db->get('vehicle_insuarance_details');
		return $query->result_array();
	}
	
	function fetch_all_by_vehicle_id($vehicle_id)
	{
		$this->db->where('vehicle_id', $vehicle_id);
		$query = $this->db->get('vehicle_insuarance_details');
		return $query;
	}

	function update_single($insuar_detail_id, $data)
	{
		$this->db->where('insuar_detail_id', $insuar_detail_id);
		$this->db->update('vehicle_insuarance_details', $data);
	}

	function delete_single($insuar_detail_id)
	{
		$this->db->where('insuar_detail_id', $insuar_detail_id);
		$this->db->delete('vehicle_insuarance_details');
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
		$this->db->from('vehicle_insuarance_details');
		$this->db->join('vehicle_insuarance_company', 'vehicle_insuarance_details.insuar_comp_id = vehicle_insuarance_company.insuar_comp_id','left');
		$this->db->join('vehicle_details', 'vehicle_insuarance_details.vehicle_id = vehicle_details.vehicle_id','left');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_single_join($insuar_detail_id)
	{
		$this->db->select('*');
		$this->db->from('vehicle_insuarance_details');
		$this->db->where('vehicle_insuarance_details.insuar_detail_id', $insuar_detail_id);
		$this->db->join('vehicle_insuarance_company', 'vehicle_insuarance_details.insuar_comp_id = vehicle_insuarance_company.insuar_comp_id','left');
		$this->db->join('vehicle_details', 'vehicle_insuarance_details.vehicle_id = vehicle_details.vehicle_id','left');
		$query = $this->db->get();
		return $query->result_array();
	}
}
