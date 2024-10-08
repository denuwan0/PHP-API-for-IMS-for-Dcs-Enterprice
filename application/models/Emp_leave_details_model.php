<?php

class Emp_leave_details_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('leave_detail_id', 'DESC');
		return $this->db->get('emp_leave_details');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_leave_details', $data);
	}

	function fetch_single($leave_detail_id)
	{
		$this->db->where('leave_detail_id', $leave_detail_id);
		$query = $this->db->get('emp_leave_details');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_leave_details');
		return $query;
	}
	
	function fetch_single_by_emp_wise_leave_quota_id($id)
	{
		$this->db->where('emp_wise_leave_quota_id', $id);
		$query = $this->db->get('emp_leave_details');
		return $query;
	}

	function update_single($leave_detail_id, $data)
	{
		$this->db->where('leave_detail_id', $leave_detail_id);
		$this->db->update('emp_leave_details', $data);
	}

	function delete_single($leave_detail_id)
	{
		$this->db->where('leave_detail_id', $leave_detail_id);
		$this->db->delete('emp_leave_details');
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
		$query = $this->db->query("SELECT * FROM `emp_leave_details`
		LEFT JOIN emp_wise_leave_quota ON emp_wise_leave_quota.emp_wise_leave_quota_id = emp_leave_details.emp_wise_leave_quota_id
		LEFT JOIN emp_leave_quota ON emp_leave_quota.leave_quota_id = emp_wise_leave_quota.leave_quota_id
		LEFT JOIN emp_details ON emp_details.emp_id = emp_leave_details.emp_id
		LEFT JOIN emp_leave_type ON emp_leave_type.leave_type_id = emp_leave_quota.leave_type_id");

		return $query;
	}
	
	function fetch_single_join($id)
	{
		$query = $this->db->query("SELECT * FROM `emp_leave_details`
		LEFT JOIN emp_wise_leave_quota ON emp_wise_leave_quota.emp_wise_leave_quota_id = emp_leave_details.emp_wise_leave_quota_id
		LEFT JOIN emp_leave_quota ON emp_leave_quota.leave_quota_id = emp_wise_leave_quota.leave_quota_id
		LEFT JOIN emp_details ON emp_details.emp_id = emp_leave_details.emp_id
		LEFT JOIN emp_leave_type ON emp_leave_type.leave_type_id = emp_leave_quota.leave_type_id
        WHERE emp_leave_details.leave_detail_id = '$id' AND emp_leave_details.is_active_leave_details = 1");

		return $query;
	}
	
	function fetch_all_join_by_branch_id($branch_id)
	{
		$query = $this->db->query("SELECT * FROM `emp_leave_details`
		LEFT JOIN emp_wise_leave_quota ON emp_wise_leave_quota.emp_wise_leave_quota_id = emp_leave_details.emp_wise_leave_quota_id
		LEFT JOIN emp_leave_quota ON emp_leave_quota.leave_quota_id = emp_wise_leave_quota.leave_quota_id
		LEFT JOIN emp_leave_type ON emp_leave_type.leave_type_id = emp_leave_quota.leave_type_id
		LEFT JOIN emp_details ON emp_details.emp_id = emp_leave_details.emp_id
		WHERE emp_details.emp_branch_id = '$branch_id' ");

		return $query;
	}
	
	function fetch_all_join_by_emp_id($emp_id)
	{
		$query = $this->db->query("SELECT * FROM `emp_leave_details`
		LEFT JOIN emp_wise_leave_quota ON emp_wise_leave_quota.emp_wise_leave_quota_id = emp_leave_details.emp_wise_leave_quota_id
		LEFT JOIN emp_leave_quota ON emp_leave_quota.leave_quota_id = emp_wise_leave_quota.leave_quota_id
		LEFT JOIN emp_leave_type ON emp_leave_type.leave_type_id = emp_leave_quota.leave_type_id
		LEFT JOIN emp_details ON emp_details.emp_id = emp_leave_details.emp_id
		WHERE emp_details.emp_id = '$emp_id'");

		return $query;
	}
	
	function fetch_branch_manager_by_branch_id($branch_id)
	{
		$query = $this->db->query("SELECT * FROM emp_details 
		LEFT JOIN sys_user ON sys_user.emp_cust_id = emp_details.emp_id
		LEFT JOIN sys_user_group ON sys_user_group.sys_user_group_id = sys_user.sys_user_group_id
		WHERE emp_details.emp_branch_id = '$branch_id' AND sys_user.is_customer = 0 AND sys_user_group.sys_user_group_name = 'Manager';");
		
		return $query->result_array();
	}
	
	function fetch_all_join_by_branch_id_for_mgr_approve($emp_id, $branch_id)
	{
		$query = $this->db->query("SELECT * FROM `emp_leave_details`
		LEFT JOIN emp_wise_leave_quota ON emp_wise_leave_quota.emp_wise_leave_quota_id = emp_leave_details.emp_wise_leave_quota_id
		LEFT JOIN emp_leave_quota ON emp_leave_quota.leave_quota_id = emp_wise_leave_quota.leave_quota_id
		LEFT JOIN emp_leave_type ON emp_leave_type.leave_type_id = emp_leave_quota.leave_type_id
		LEFT JOIN emp_details ON emp_details.emp_id = emp_leave_details.emp_id
		WHERE emp_details.emp_id != '$emp_id' AND emp_details.emp_branch_id = '$branch_id' AND emp_leave_details.is_active_leave_details = 1");
		
		

		return $query;
	}
	
	
	
}
