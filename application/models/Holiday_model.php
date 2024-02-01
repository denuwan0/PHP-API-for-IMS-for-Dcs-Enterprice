<?php

class Holiday_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('holiday_id', 'DESC');
		return $this->db->get('holiday');
	}
	
	function fetch_all_active(){
		$this->db->order_by('holiday_id', 'ASC');
		$this->db->where('is_active_holiday', 1);
		return $this->db->get('holiday');
	}
	
	function insert($data)
	{
		$this->db->insert('holiday', $data);
	}

	function fetch_single($holiday_id)
	{
		$this->db->where('holiday_id', $holiday_id);
		$query = $this->db->get('holiday');
		return $query->result_array();
	}
	
	function fetch_all_active_by_type($type_id)
	{			
		$this->db->order_by('holiday_id', 'ASC');
		$this->db->where('is_active_holiday', 1);
		$this->db->where('holiday_type_id', $type_id);
		$query = $this->db->get('holiday');
		return $query;
	}

	function update_single($holiday_id, $data)
	{
		$this->db->where('holiday_id', $holiday_id);
		$this->db->update('holiday', $data);
	}
	
	/* function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('holiday');
		$this->db->join('country', 'location.country_id = country.country_id','left');
		//$this->db->where('company.company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	} */

	function delete_single($holiday_id)
	{
		$this->db->where('holiday_id', $holiday_id);
		$this->db->delete('holiday');
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
