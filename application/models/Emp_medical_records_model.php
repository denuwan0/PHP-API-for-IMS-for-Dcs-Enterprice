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
	
	function fetch_single_by_emp_med_loc_id($emp_med_loc_id)
	{
		$this->db->where('med_loc_id', $emp_med_loc_id);
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
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('emp_medical_records');
		$this->db->join('emp_details', 'emp_medical_records.emp_id = emp_details.emp_id','left');
		$this->db->join('emp_medical_checkup_location', 'emp_medical_records.med_loc_id = emp_medical_checkup_location.emp_med_loc_id','left');
		$query = $this->db->get();
		return $query;
	}
	
	function fetch_single_join($med_record_id)
	{
		$this->db->select('*');
		$this->db->from('emp_medical_records');
		$this->db->where('med_record_id', $med_record_id);
		$this->db->join('emp_details', 'emp_medical_records.emp_id = emp_details.emp_id','left');
		$this->db->join('emp_medical_checkup_location', 'emp_medical_records.med_loc_id = emp_medical_checkup_location.emp_med_loc_id','left');
		$query = $this->db->get();
		return $query;
	}
	
	function fetch_all_join_by_branch_id($emp_branch_id)
	{
		$this->db->select('*');
		$this->db->from('emp_medical_records');
		$this->db->where('emp_details.emp_branch_id', $emp_branch_id);
		$this->db->join('emp_details', 'emp_medical_records.emp_id = emp_details.emp_id','left');
		$this->db->join('emp_medical_checkup_location', 'emp_medical_records.med_loc_id = emp_medical_checkup_location.emp_med_loc_id','left');
		$query = $this->db->get();
		return $query;
	}
	
	function fetch_single_join_by_emp_id($emp_id)
	{
		$this->db->select('*');
		$this->db->from('emp_medical_records');
		$this->db->where('emp_details.emp_id', $emp_id);
		$this->db->join('emp_details', 'emp_medical_records.emp_id = emp_details.emp_id','left');
		$this->db->join('emp_medical_checkup_location', 'emp_medical_records.med_loc_id = emp_medical_checkup_location.emp_med_loc_id','left');
		$query = $this->db->get();
		return $query;
	}
	
}
