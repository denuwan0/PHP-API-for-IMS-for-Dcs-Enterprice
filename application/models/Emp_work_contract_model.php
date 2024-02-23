<?php

class Emp_work_contract_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('work_contract_id', 'DESC');
		return $this->db->get('emp_work_contract');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_work_contract', $data);
	}

	function fetch_single($work_contract_id)
	{
		$this->db->where('work_contract_id', $work_contract_id);
		$query = $this->db->get('emp_work_contract');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_work_contract');
		return $query;
	}

	function update_single($work_contract_id, $data)
	{
		$this->db->where('work_contract_id', $work_contract_id);
		$this->db->update('emp_work_contract', $data);
	}

	function delete_single($work_contract_id)
	{
		$this->db->where('work_contract_id', $work_contract_id);
		$this->db->delete('emp_work_contract');
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
		$this->db->from('emp_work_contract');
		$this->db->join('emp_details', 'emp_work_contract.emp_id = emp_details.emp_id','left');
		$this->db->join('emp_grade', 'emp_work_contract.emp_grade_id = emp_grade.emp_grade_id','left');
		$this->db->join('company_branch', 'emp_work_contract.emp_branch_id = company_branch.company_branch_id','left');
		$this->db->join('company', 'emp_work_contract.emp_company_id = company.company_id','left');
		$this->db->join('emp_designation', 'emp_work_contract.emp_desig_id = emp_designation.emp_desig_id','left');
		$this->db->join('emp_work_schedule', 'emp_work_contract.emp_ws_id = emp_work_schedule.ws_id','left');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('emp_work_contract');
		$this->db->join('emp_details', 'emp_work_contract.emp_id = emp_details.emp_id','left');
		$this->db->join('emp_grade', 'emp_work_contract.emp_grade_id = emp_grade.emp_grade_id','left');
		$this->db->join('company_branch', 'emp_work_contract.emp_branch_id = company_branch.company_branch_id','left');
		$this->db->join('company', 'emp_work_contract.emp_company_id = company.company_id','left');
		$this->db->join('emp_designation', 'emp_work_contract.emp_desig_id = emp_designation.emp_desig_id','left');
		$this->db->join('emp_work_schedule', 'emp_work_contract.emp_ws_id = emp_work_schedule.ws_id','left');
		$this->db->where('work_contract_id ', $work_contract_id);
		$query = $this->db->get();
		return $query->result_array();
	}
		
	function fetch_single_join($work_contract_id)
	{
		$this->db->select('*');
		$this->db->from('emp_work_contract');
		$this->db->join('emp_details', 'emp_work_contract.emp_id = emp_details.emp_id','left');
		$this->db->join('emp_grade', 'emp_work_contract.emp_grade_id = emp_grade.emp_grade_id','left');
		$this->db->join('company_branch', 'emp_work_contract.emp_branch_id = company_branch.company_branch_id','left');
		$this->db->join('company', 'emp_work_contract.emp_company_id = company.company_id','left');
		$this->db->join('emp_designation', 'emp_work_contract.emp_desig_id = emp_designation.emp_desig_id','left');
		$this->db->join('emp_work_schedule', 'emp_work_contract.emp_ws_id = emp_work_schedule.ws_id','left');
		$this->db->where('work_contract_id ', $work_contract_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_by_emp_grade_id($emp_grade_id)
	{
		$this->db->where('emp_grade_id', $emp_grade_id);
		$this->db->where('is_active_emp_work_cont', 1);
		$query = $this->db->get('emp_work_contract');
		return $query;
	}
	
	function fetch_all_by_emp_desig_id($emp_desig_id)
	{
		$this->db->where('emp_desig_id', $emp_desig_id);
		$this->db->where('is_active_emp_work_cont', 1);
		$query = $this->db->get('emp_work_contract');
		return $query;
	}
	
	function fetch_all_by_ws_id($emp_ws_id)
	{
		$this->db->where('emp_ws_id', $emp_ws_id);
		$this->db->where('is_active_emp_work_cont', 1);
		$query = $this->db->get('emp_work_contract');
		return $query;
	}
	
}
