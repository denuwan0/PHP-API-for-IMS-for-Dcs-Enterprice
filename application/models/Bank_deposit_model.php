<?php

class Bank_deposit_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('bank_deposit_id', 'DESC');
		return $this->db->get('bank');
	}
	
	function insert($data)
	{
		$this->db->insert('bank_deposit', $data);
	}

	function fetch_single($bank_deposit_id)
	{
		$this->db->where('bank_deposit_id', $bank_deposit_id);
		$query = $this->db->get('bank_deposit');
		return $query->result_array();
	}
	
	function fetch_all_by_branch_id($branch_id)
	{
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get('bank_deposit');
		return $query;
	}
	
	function fetch_all_by_b_account_id($b_account_id)
	{
		$this->db->where('account_id', $b_account_id);
		$query = $this->db->get('bank_deposit');
		return $query;
	}

	function update_single($bank_deposit_id, $data)
	{
		$this->db->where('bank_deposit_id', $bank_deposit_id);
		$this->db->update('bank_deposit', $data);
	}

	function delete_single($bank_deposit_id)
	{
		$this->db->where('bank_deposit_id', $bank_deposit_id);
		$this->db->delete('bank_deposit');
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
