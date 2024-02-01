<?php

class Bank_branch_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('b_branch_id', 'DESC');
		return $this->db->get('bank_branch');
	}
	
	function fetch_all_active(){
		$this->db->order_by('b_branch_id', 'DESC');
		$this->db->where('is_active_bank_b_branch', 1);
		return $this->db->get('bank_branch');
	}	
	
	function insert($data)
	{
		$this->db->insert('bank_branch', $data);
	}

	function fetch_single($b_branch_id)
	{
		$this->db->where('b_branch_id', $b_branch_id);
		$query = $this->db->get('bank_branch');
		return $query->result_array();
	}
	
	function fetch_single_join($b_branch_id)
	{
		$this->db->select('*');
		$this->db->from('bank_branch');
		$this->db->join('bank', 'bank_branch.bank_id = bank.bank_id','left');
		$this->db->join('location', 'bank_branch.location_id = location.location_id','left');
		$this->db->where('b_branch_id', $b_branch_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_by_bank_id($b_branch_id)
	{
		$this->db->where('b_branch_id', $b_branch_id);
		$query = $this->db->get('bank_branch');
		return $query;
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('bank_branch');
		$this->db->join('bank', 'bank_branch.bank_id = bank.bank_id','left');
		$this->db->join('location', 'bank_branch.location_id = location.location_id','left');
		//$this->db->where('company.company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	function update_single($b_branch_id, $data)
	{
		$this->db->where('b_branch_id', $b_branch_id);
		$this->db->update('bank_branch', $data);
	}

	function delete_single($b_branch_id)
	{
		$this->db->where('b_branch_id', $b_branch_id);
		$this->db->delete('bank_branch');
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
