<?php

class Holiday_type_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('holiday_type_id', 'DESC');
		return $this->db->get('holiday_type');
	}
	
	function fetch_all_active(){
		$this->db->order_by('holiday_type_id', 'ASC');
		$this->db->where('is_active_holiday_type', 1);
		return $this->db->get('holiday_type');
	}
	
	function insert($data)
	{
		$this->db->insert('holiday_type', $data);
	}

	function fetch_single($holiday_type_id)
	{
		$this->db->where('holiday_type_id', $holiday_type_id);
		$query = $this->db->get('holiday_type');
		return $query->result_array();
	}

	function update_single($holiday_type_id, $data)
	{
		$this->db->where('holiday_type_id', $holiday_type_id);
		$this->db->update('holiday_type', $data);
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

	function delete_single($holiday_type_id)
	{
		$this->db->where('holiday_type_id', $holiday_type_id);
		$this->db->delete('holiday_type');
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
