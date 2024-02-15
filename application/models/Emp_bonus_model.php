<?php

class Emp_bonus_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('bonus_id', 'ASC');
		return $this->db->get('emp_bonus');
	}
	
	function fetch_all_active(){
		$this->db->where('is_active_bonus', 1);
		$this->db->order_by('bonus_id', 'ASC');
		return $this->db->get('emp_bonus');
	}
	
	function fetch_all_active_by_branch_id($branch_id){
		$this->db->where('is_active_bonus', 1);
		$this->db->where('branch_id', $branch_id);
		$this->db->order_by('bonus_id', 'ASC');
		$this->db->get('emp_bonus');
		return $this->db->last_query();
		//var_dump($this->db->last_query());
	}
	
	function insert($data)
	{
		$this->db->insert('emp_bonus', $data);
	}

	function fetch_single($bonus_id)
	{
		$this->db->where('bonus_id', $bonus_id);
		$query = $this->db->get('emp_bonus');
		return $query->result_array();
	}
	
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('emp_bonus');
		$query = $this->db->get();
		return $query->result_array();
	}
		

	function update_single($bonus_id, $data)
	{
		$this->db->where('bonus_id', $bonus_id);
		$this->db->update('emp_bonus', $data);
	}

	function delete_single($bonus_id)
	{
		$this->db->where('bonus_id', $bonus_id);
		$this->db->delete('emp_bonus');
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
