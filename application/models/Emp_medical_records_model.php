<?php

class Emp_medical_records_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('med_record_id', 'DESC');
		return $this->db->get('emp_medical_records');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_medical_records', $data);
	}

	function fetch_single($med_record_id)
	{
		$this->db->where('med_record_id', $med_record_id);
		$query = $this->db->get('emp_medical_records');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_medical_records');
		return $query;
	}

	function update_single($med_record_id, $data)
	{
		$this->db->where('med_record_id', $med_record_id);
		$this->db->update('emp_medical_records', $data);
	}

	function delete_single($med_record_id)
	{
		$this->db->where('med_record_id', $med_record_id);
		$this->db->delete('emp_medical_records');
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
