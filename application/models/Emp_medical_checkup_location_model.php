<?php

class Emp_medical_checkup_location_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('emp_med_loc_id', 'ASC');
		return $this->db->get('emp_medical_checkup_location');
	}
	
	function fetch_all_active(){
		$this->db->order_by('emp_med_loc_id', 'ASC');
		$this->db->where('is_active_medical_checkup', 1);
		return $this->db->get('emp_medical_checkup_location');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_medical_checkup_location', $data);
	}

	function fetch_single($emp_med_loc_id)
	{
		$this->db->where('emp_med_loc_id', $emp_med_loc_id);
		$query = $this->db->get('emp_medical_checkup_location');
		return $query->result_array();
	}

	function update_single($emp_med_loc_id, $data)
	{
		$this->db->where('emp_med_loc_id', $emp_med_loc_id);
		$this->db->update('emp_medical_checkup_location', $data);
	}

	function delete_single($emp_med_loc_id)
	{
		$this->db->where('emp_med_loc_id', $emp_med_loc_id);
		$this->db->delete('emp_medical_checkup_location');
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
