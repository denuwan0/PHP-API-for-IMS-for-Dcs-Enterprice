<?php

class Emp_drive_license_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('driving_license_id', 'DESC');
		return $this->db->get('emp_driving_license');
	}
	
	function fetch_all_active(){
		$this->db->where('is_active_driving_lice', 1);
		return $this->db->get('emp_driving_license');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_driving_license', $data);
	}

	function fetch_single($driving_license_id)
	{
		$this->db->where('driving_license_id', $driving_license_id);
		$query = $this->db->get('emp_driving_license');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_driving_license');
		return $query;
	}

	function update_single($driving_license_id, $data)
	{
		$this->db->where('driving_license_id', $driving_license_id);
		$this->db->update('emp_driving_license', $data);
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('emp_driving_license');
		$this->db->join('emp_details', 'emp_details.emp_id = emp_driving_license.emp_id','left');
		$query = $this->db->get();
		return $query->result_array();
	}

	function delete_single($driving_license_id)
	{
		$this->db->where('driving_license_id', $driving_license_id);
		$this->db->delete('emp_driving_license');
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
