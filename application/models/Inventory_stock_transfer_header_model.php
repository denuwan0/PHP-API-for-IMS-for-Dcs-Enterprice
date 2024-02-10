<?php

class Inventory_stock_transfer_header_model extends CI_Model{   
    
	function fetch_all(){
		$query = $this->db->get('inventory_stock_transfer_header');
		return $query;
	}
	
	function fetch_all_join()
	{
		$query = $this->db->query("SELECT inventory_stock_transfer_header.inventory_stock_transfer_header_id, inventory_stock_transfer_header.branch_id_from as branch_id_from, inventory_stock_transfer_header.branch_id_to as branch_id_to, inventory_stock_transfer_header.create_date, inventory_stock_transfer_header.create_time, inventory_stock_transfer_header.created_by, inventory_stock_transfer_header.transfer_type, inventory_stock_transfer_header.stock_type, inventory_stock_transfer_header.approved_by, inventory_stock_transfer_header.is_approved, inventory_stock_transfer_header.is_accepted, inventory_stock_transfer_header.accepted_by, inventory_stock_transfer_header.is_active_inv_stock_trans,
		branch_from.company_branch_name as from_branch, branch_to.company_branch_name as to_branch
		FROM inventory_stock_transfer_header
		left join company_branch AS branch_to ON inventory_stock_transfer_header.branch_id_to = branch_to.company_branch_id  
        left join company_branch AS branch_from ON inventory_stock_transfer_header.branch_id_from = branch_from.company_branch_id");
		return $query->result_array();
	}

	
	function fetch_all_by_branch_id($branch_id){
		
		$query = $this->db->query("SELECT inventory_stock_transfer_header.inventory_stock_transfer_header_id, inventory_stock_transfer_header.branch_id_from as branch_id_from, inventory_stock_transfer_header.branch_id_to as branch_id_to, inventory_stock_transfer_header.create_date, inventory_stock_transfer_header.create_time, inventory_stock_transfer_header.created_by, inventory_stock_transfer_header.transfer_type, inventory_stock_transfer_header.stock_type, inventory_stock_transfer_header.approved_by, inventory_stock_transfer_header.is_approved, inventory_stock_transfer_header.is_accepted, inventory_stock_transfer_header.accepted_by, inventory_stock_transfer_header.is_active_inv_stock_trans,
		branch_from.company_branch_name as from_branch, branch_to.company_branch_name as to_branch
		FROM inventory_stock_transfer_header
		left join company_branch AS branch_to ON inventory_stock_transfer_header.branch_id_to = branch_to.company_branch_id  
        left join company_branch AS branch_from ON inventory_stock_transfer_header.branch_id_from = branch_from.company_branch_id
		WHERE inventory_stock_transfer_header.branch_id_from = '$branch_id'");
		return $query->result_array();
	}
	
	function fetch_all_by_other_branch_id($branch_id){
		
		$query = $this->db->query("SELECT inventory_stock_transfer_header.inventory_stock_transfer_header_id, inventory_stock_transfer_header.branch_id_from as branch_id_from, inventory_stock_transfer_header.branch_id_to as branch_id_to, inventory_stock_transfer_header.create_date, inventory_stock_transfer_header.create_time, inventory_stock_transfer_header.created_by, inventory_stock_transfer_header.transfer_type, inventory_stock_transfer_header.stock_type, inventory_stock_transfer_header.approved_by, inventory_stock_transfer_header.is_approved, inventory_stock_transfer_header.is_accepted, inventory_stock_transfer_header.accepted_by, inventory_stock_transfer_header.is_active_inv_stock_trans,
		branch_from.company_branch_name as from_branch, branch_to.company_branch_name as to_branch
		FROM inventory_stock_transfer_header
		left join company_branch AS branch_to ON inventory_stock_transfer_header.branch_id_to = branch_to.company_branch_id  
        left join company_branch AS branch_from ON inventory_stock_transfer_header.branch_id_from = branch_from.company_branch_id
		WHERE inventory_stock_transfer_header.branch_id_to = '$branch_id'");
		return $query->result_array();
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_stock_transfer_header', $data);
		return $this->db->insert_id();
	}

	function fetch_single($transfer_id)
	{
		
		$query = $this->db->query("SELECT inventory_stock_transfer_header.inventory_stock_transfer_header_id, inventory_stock_transfer_header.branch_id_from as branch_id_from, inventory_stock_transfer_header.branch_id_to as branch_id_to, inventory_stock_transfer_header.create_date, inventory_stock_transfer_header.create_time, inventory_stock_transfer_header.created_by, inventory_stock_transfer_header.transfer_type, inventory_stock_transfer_header.stock_type, inventory_stock_transfer_header.approved_by, inventory_stock_transfer_header.is_approved, inventory_stock_transfer_header.is_accepted, inventory_stock_transfer_header.accepted_by, inventory_stock_transfer_header.is_active_inv_stock_trans,
		branch_from.company_branch_name as from_branch, branch_to.company_branch_name as to_branch
		FROM inventory_stock_transfer_header
		join company_branch AS branch_to ON inventory_stock_transfer_header.branch_id_to = branch_to.company_branch_id  
        join company_branch AS branch_from ON inventory_stock_transfer_header.branch_id_from = branch_from.company_branch_id
		WHERE inventory_stock_transfer_header.inventory_stock_transfer_header_id = '$transfer_id'");
		return $query->result_array();
	}
	
	function fetch_created_user_info($transfer_id)
	{
		
		$query = $this->db->query("SELECT inventory_stock_transfer_header.inventory_stock_transfer_header_id, inventory_stock_transfer_header.branch_id_from as branch_id_from, inventory_stock_transfer_header.branch_id_to as branch_id_to, inventory_stock_transfer_header.create_date, inventory_stock_transfer_header.create_time, inventory_stock_transfer_header.created_by, inventory_stock_transfer_header.transfer_type, inventory_stock_transfer_header.stock_type, inventory_stock_transfer_header.approved_by, inventory_stock_transfer_header.is_approved, inventory_stock_transfer_header.is_accepted, inventory_stock_transfer_header.accepted_by, inventory_stock_transfer_header.is_active_inv_stock_trans,
		branch_from.company_branch_name as from_branch, branch_to.company_branch_name as to_branch, sys_user.emp_cust_id, emp_details.emp_first_name, emp_details.emp_email, emp_details.emp_contact_no
		FROM inventory_stock_transfer_header
		join company_branch AS branch_to ON inventory_stock_transfer_header.branch_id_to = branch_to.company_branch_id  
        join company_branch AS branch_from ON inventory_stock_transfer_header.branch_id_from = branch_from.company_branch_id
        join sys_user ON sys_user.user_id = inventory_stock_transfer_header.created_by
        join emp_details ON emp_details.emp_id = sys_user.emp_cust_id
		WHERE inventory_stock_transfer_header.inventory_stock_transfer_header_id = '$transfer_id'");
		return $query->result_array();
	}
	
	function fetch_received_user_info($transfer_id)
	{
		
		$query = $this->db->query("SELECT inventory_stock_transfer_header.inventory_stock_transfer_header_id, inventory_stock_transfer_header.branch_id_from as branch_id_from, inventory_stock_transfer_header.branch_id_to as branch_id_to, inventory_stock_transfer_header.create_date, inventory_stock_transfer_header.create_time, inventory_stock_transfer_header.created_by, inventory_stock_transfer_header.transfer_type, inventory_stock_transfer_header.stock_type, inventory_stock_transfer_header.approved_by, inventory_stock_transfer_header.is_approved, inventory_stock_transfer_header.is_accepted, inventory_stock_transfer_header.accepted_by, inventory_stock_transfer_header.is_active_inv_stock_trans,
		branch_from.company_branch_name as from_branch, branch_to.company_branch_name as to_branch, sys_user.emp_cust_id, emp_details.emp_first_name, emp_details.emp_email, emp_details.emp_contact_no
		FROM inventory_stock_transfer_header
		join company_branch AS branch_to ON inventory_stock_transfer_header.branch_id_to = branch_to.company_branch_id  
        join company_branch AS branch_from ON inventory_stock_transfer_header.branch_id_from = branch_from.company_branch_id
        join sys_user ON sys_user.user_id = inventory_stock_transfer_header.created_by
        join emp_details ON emp_details.emp_id = sys_user.emp_cust_id
		WHERE inventory_stock_transfer_header.inventory_stock_transfer_header_id = '$transfer_id'");
		return $query->result_array();
	}

	function update_single($transfer_id, $data)
	{
		$this->db->where('inventory_stock_transfer_header_id', $transfer_id);
		$this->db->update('inventory_stock_transfer_header', $data);
	}

	function delete_single($transfer_id)
	{
		$this->db->where('transfer_id', $transfer_id);
		$this->db->delete('inventory_stock_transfer_header');
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
