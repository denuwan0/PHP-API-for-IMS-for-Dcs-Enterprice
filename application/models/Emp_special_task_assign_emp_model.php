<?php

class Emp_special_task_assign_emp_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('assign_emp_line_id', 'ASC');
		return $this->db->get('emp_special_task_assign_emp');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_special_task_assign_emp', $data);
	}

	function fetch_single($assign_emp_line_id)
	{
		$this->db->where('assign_emp_line_id', $assign_emp_line_id);
		$query = $this->db->get('emp_special_task_assign_emp');
		return $query;
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_special_task_assign_emp');
		return $query;
	}

	function update_single($assign_emp_line_id, $data)
	{
		$this->db->where('assign_emp_line_id', $assign_emp_line_id);
		$this->db->update('emp_special_task_assign_emp', $data);
	}

	function delete_single($assign_emp_line_id)
	{
		$this->db->where('assign_emp_line_id', $assign_emp_line_id);
		$this->db->delete('emp_special_task_assign_emp');
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
		$this->db->from('emp_special_task_assign_emp');
		//$this->db->where('company.company_id', $company_id);
		$this->db->join('emp_special_task_header', 'emp_special_task_assign_emp.special_task_id = emp_special_task_header.special_task_id','left');
		$this->db->join('company_branch', 'emp_special_task_assign_emp.branch_id = company_branch.company_branch_id ','left');
		$this->db->join('emp_details', 'emp_special_task_assign_emp.emp_id = emp_details.emp_id','left');
		$this->db->join('inventory_retail_invoice_header', 'emp_special_task_assign_emp.invoice_id  = inventory_retail_invoice_header.invoice_id ','left');
		$query = $this->db->get();
		return $query;
	}
	
	function fetch_all_daily_join_staff($emp_id)
	{
		$query = $this->db->query("SELECT * FROM `emp_special_task_assign_emp` 
		LEFT JOIN emp_details ON emp_details.emp_id = emp_special_task_assign_emp.emp_id
		LEFT JOIN company_branch ON company_branch.company_branch_id = emp_special_task_assign_emp.branch_id 
		LEFT JOIN emp_special_task_header ON emp_special_task_header.special_task_id = emp_special_task_assign_emp.special_task_id
		WHERE `task_start_date` <= CURDATE() AND `task_end_date` >= CURDATE() AND emp_special_task_assign_emp.emp_id = '$emp_id';");
		
		return $query;
	}
	
	function fetch_all_daily_join_by_branch_id($branch_id)
	{
		$query = $this->db->query("SELECT * FROM `emp_special_task_assign_emp` 
		LEFT JOIN emp_details ON emp_details.emp_id = emp_special_task_assign_emp.emp_id
		LEFT JOIN company_branch ON company_branch.company_branch_id = emp_special_task_assign_emp.branch_id 
		LEFT JOIN emp_special_task_header ON emp_special_task_header.special_task_id = emp_special_task_assign_emp.special_task_id
		WHERE `task_start_date` <= CURDATE() AND `task_end_date` >= CURDATE() AND  emp_special_task_assign_emp.branch_id = '$branch_id';");
		
		return $query;
	}
	
	function fetch_all_active_join_by_branch_id($branch_id)
	{
		$this->db->select('*');
		$this->db->from('emp_special_task_assign_emp');
		$this->db->join('emp_special_task_header', 'emp_special_task_assign_emp.special_task_id = emp_special_task_header.special_task_id','left');
		$this->db->join('company_branch', 'emp_special_task_assign_emp.branch_id = company_branch.company_branch_id ','left');
		$this->db->join('emp_details', 'emp_special_task_assign_emp.emp_id = emp_details.emp_id','left');
		$this->db->join('inventory_retail_invoice_header', 'emp_special_task_assign_emp.invoice_id  = inventory_retail_invoice_header.invoice_id ','left');
		$this->db->where('emp_special_task_assign_emp.branch_id', $branch_id);
		$query = $this->db->get();
		return $query;
	}
	
	function fetch_all_active_join_by_emp_id($emp_id)
	{
		$this->db->select('*');
		$this->db->from('emp_special_task_assign_emp');
		$this->db->join('emp_special_task_header', 'emp_special_task_assign_emp.special_task_id = emp_special_task_header.special_task_id','left');
		$this->db->join('company_branch', 'emp_special_task_assign_emp.branch_id = company_branch.company_branch_id ','left');
		$this->db->join('emp_details', 'emp_special_task_assign_emp.emp_id = emp_details.emp_id','left');
		$this->db->join('inventory_retail_invoice_header', 'emp_special_task_assign_emp.invoice_id  = inventory_retail_invoice_header.invoice_id ','left');
		$this->db->where('emp_special_task_assign_emp.emp_id', $emp_id);
		$query = $this->db->get();
		return $query;
	}
	
}
