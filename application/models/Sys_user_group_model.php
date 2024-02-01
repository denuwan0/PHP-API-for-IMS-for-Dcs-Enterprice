<?php

class Sys_user_group_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('sys_user_group_id', 'DESC');
		$query = $this->db->get('sys_user_group');
		return $query->result_array();
	}
	
	function fetch_all_active(){
		$query = $this->db->get('sys_user_group');
		$this->db->where('is_active_sys_user_group', 1);
		return $query->result_array();
	}
	
	function insert($data)
	{
		$this->db->insert('sys_user_group', $data);
	}

	function fetch_single($sys_user_group_id)
	{
		$this->db->where('sys_user_group_id', $sys_user_group_id);
		$query = $this->db->get('sys_user_group');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_cust_id', $emp_id);
		$query = $this->db->get('sys_user_group');
		return $query->result_array();
	}
	
	function fetch_single_by_customer_id($customer_id)
	{
		$this->db->where('emp_cust_id', $customer_id);
		$query = $this->db->get('sys_user_group');
		return $query->result_array();
	}

	function update_single($sys_user_group_id, $data)
	{
		$this->db->where('sys_user_group_id', $sys_user_group_id);
		$this->db->update('sys_user_group', $data);
	}

	function delete_single($sys_user_group_id)
	{
		$this->db->where('sys_user_group_id', $sys_user_group_id);
		$this->db->delete('sys_user_group');
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
