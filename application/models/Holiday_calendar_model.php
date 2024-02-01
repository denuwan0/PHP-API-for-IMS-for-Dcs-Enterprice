<?php

class Holiday_calendar_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('h_calendar_id', 'DESC');
		return $this->db->get('holiday_calendar');
	}
	
	function fetch_all_active(){
		$this->db->order_by('h_calendar_id', 'ASC');
		$this->db->where('is_active_location', 1);
		return $this->db->get('holiday_calendar');
	}
	
	function insert($data)
	{
		$this->db->insert('holiday_calendar', $data);
	}

	function fetch_single($h_calendar_id)
	{
		$this->db->where('h_calendar_id', $h_calendar_id);
		$query = $this->db->get('holiday_calendar');
		return $query->result_array();
	}
	
	function fetch_all_by_holiday_id($holiday_id)
	{
		$this->db->where('holiday_id', $holiday_id);
		$query = $this->db->get('holiday_calendar');
		return $query;
	}

	function update_single($h_calendar_id, $data)
	{
		$this->db->where('h_calendar_id', $h_calendar_id);
		$this->db->update('holiday_calendar', $data);
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('holiday_calendar');
		$this->db->join('holiday', 'holiday_calendar.holiday_id = holiday.holiday_id','left');
		$this->db->join('holiday_type', 'holiday.holiday_type_id = holiday_type.holiday_type_id','left');
		//$this->db->where('holiday_calendar.is_active_h_calendar', 1);
		//$this->db->where('company.company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	function delete_single($h_calendar_id)
	{
		$this->db->where('h_calendar_id', $h_calendar_id);
		$this->db->delete('holiday_calendar');
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
