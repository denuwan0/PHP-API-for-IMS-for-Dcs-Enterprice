<?php

class Location_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('location_id', 'DESC');
		return $this->db->get('location');
	}
	
	function fetch_all_active(){
		$this->db->order_by('location_id', 'ASC');
		$this->db->where('is_active_location', 1);
		return $this->db->get('location');
	}
	
	function insert($data)
	{
		$this->db->insert('location', $data);
	}

	function fetch_single($location_id)
	{
		$this->db->where('location_id', $location_id);
		$query = $this->db->get('location');
		return $query->result_array();
	}

	function update_single($location_id, $data)
	{
		$this->db->where('location_id', $location_id);
		$this->db->update('location', $data);
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('location');
		$this->db->join('country', 'location.country_id = country.country_id','left');
		//$this->db->where('company.company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_by_country_id($country_id)
	{
		$this->db->where('country_id', $country_id);
		$query = $this->db->get('location');
		return $query;
	}

	function delete_single($location_id)
	{
		$this->db->where('location_id', $location_id);
		$this->db->delete('location');
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
