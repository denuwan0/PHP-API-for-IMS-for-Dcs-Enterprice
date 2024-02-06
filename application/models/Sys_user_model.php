<?php

class Sys_user_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('user_id', 'DESC');
		return $this->db->get('sys_user');
	}
	
	function insert($data)
	{
		$this->db->insert('sys_user', $data);
	}

	function fetch_single($user_id)
	{
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('sys_user');
		return $query->result_array();
	}
	
	function fetch_single_join($user_id)
	{
		$this->db->where('sys_user.user_id', $user_id);
		$this->db->join('sys_user_group', 'sys_user.sys_user_group_id = sys_user_group.sys_user_group_id','left');
		$query = $this->db->get('sys_user');
		return $query->result_array();
	}
	
	function fetch_single_join_by_user_id_and_otp($user_id, $otp_code)
	{
		$this->db->where('sys_user.user_id', $user_id);
		$this->db->where('sys_user.otp_code', $otp_code);
		$this->db->join('sys_user_group', 'sys_user.sys_user_group_id = sys_user_group.sys_user_group_id','left');
		$query = $this->db->get('sys_user');
		return $query->result_array();
	}
	
	function fetch_single_join_by_emp_id($emp_id)
	{
		$this->db->where('sys_user.emp_cust_id', $emp_id);
		$this->db->where('sys_user.is_customer', 0);
		$this->db->join('sys_user_group', 'sys_user.sys_user_group_id = sys_user_group.sys_user_group_id','left');
		$query = $this->db->get('sys_user');
		return $query->result_array();
	}
	
	function fetch_single_join_by_cust_id($emp_id)
	{
		$this->db->where('sys_user.emp_cust_id', $emp_id);
		$this->db->where('sys_user.is_customer', 1);
		$this->db->join('sys_user_group', 'sys_user.sys_user_group_id = sys_user_group.sys_user_group_id','left');
		$query = $this->db->get('sys_user');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('sys_user.emp_cust_id', $emp_id);
		$this->db->where('sys_user.is_customer', 0);
		$this->db->join('sys_user_group', 'sys_user.sys_user_group_id = sys_user_group.sys_user_group_id','left');
		$query = $this->db->get('sys_user');
		return $query->result_array();
	}
	
	function fetch_single_by_customer_id($customer_id)
	{
		$this->db->where('emp_cust_id', $customer_id);
		$query = $this->db->get('sys_user');
		return $query;
	}
	
	function fetch_all_by_user_group_id($user_group_id)
	{
		$this->db->where('sys_user_group_id', $user_group_id);
		$query = $this->db->get('sys_user');
		return $query;
	}
	
	function validate_user($username, $password)
	{
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$query = $this->db->get('sys_user');
		return $query->result_array();
	}
	
	function validate_user_join($username, $password)
	{
		$this->db->where('sys_user.username', $username);
		$this->db->where('sys_user.password', $password);
		$this->db->join('sys_user_group', 'sys_user.sys_user_group_id = sys_user_group.sys_user_group_id','left');
		$query = $this->db->get('sys_user');
		return $query->result_array();
	}
	
	function validate_otp($user_id, $otp_code)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('otp_code', $otp_code);
		$query = $this->db->get('sys_user');
		return $query->result_array();
	}

	function update_single($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update('sys_user', $data);
	}

	function delete_single($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('sys_user');
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
		$this->db->from('sys_user');
		$this->db->join('sys_user_group', 'sys_user.sys_user_group_id = sys_user_group.sys_user_group_id','left');
		$query = $this->db->get();
		return $query;
	}
	
	function fetch_active_single_join($user_id)
	{
		$this->db->where('sys_user.user_id', $user_id);
		$this->db->where('sys_user.is_active_sys_user', 1);
		$this->db->join('sys_user_group', 'sys_user.sys_user_group_id = sys_user_group.sys_user_group_id','left');
		$query = $this->db->get('sys_user');
		return $query->result_array();
	}
}
