<?php

class Bank_account_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('account_id', 'DESC');
		return $this->db->get('bank_account_details');
	}
	
	function insert($data)
	{
		$this->db->insert('bank_account_details', $data);
	}

	function fetch_single($account_id)
	{
		$this->db->where('account_id', $account_id);
		$query = $this->db->get('bank_account_details');
		return $query->result_array();
	}
	
	function fetch_all_by_bank_branch_id($b_branch_id)
	{
		$this->db->where('b_branch_id', $b_branch_id);
		$query = $this->db->get('bank_account_details');
		return $query;
	}
	
	function fetch_single_join($account_id)
	{
		$this->db->select('*');
		$this->db->from('bank_account_details');
		$this->db->join('bank_branch', 'bank_account_details.b_branch_id = bank_branch.b_branch_id','left');
		$this->db->join('bank', 'bank_branch.bank_id = bank.bank_id','left');
		$this->db->where('bank_account_details.account_id', $account_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('bank_account_details');
		$this->db->join('bank_branch', 'bank_account_details.b_branch_id = bank_branch.b_branch_id','left');
		$this->db->join('bank', 'bank_branch.bank_id = bank.bank_id','left');
		//$this->db->where('company.company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	function update_single($account_id, $data)
	{
		$this->db->where('account_id', $account_id);
		$this->db->update('bank_account_details', $data);
	}

	function delete_single($account_id)
	{
		$this->db->where('account_id', $account_id);
		$this->db->delete('bank_account_details');
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
