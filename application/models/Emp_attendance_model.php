<?php

class Emp_attendance_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('attendance_id', 'DESC');
		return $this->db->get('emp_attendance');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_attendance', $data);
	}

	function fetch_single($attendance_id)
	{
		$this->db->where('attendance_id', $attendance_id);
		$query = $this->db->get('emp_attendance');
		return $query->result_array();
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('emp_attendance');
		$query = $this->db->get();
		return $query->result_array();
	}
		

	function update_single($attendance_id, $data)
	{
		$this->db->where('attendance_id', $attendance_id);
		$this->db->update('emp_attendance', $data);
	}

	function delete_single($attendance_id)
	{
		$this->db->where('attendance_id', $attendance_id);
		$this->db->delete('emp_attendance');
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
