<?php

class Dashboard_model extends CI_Model{   
    
	function fetch_all_active_system_user_count_admin()
	{
		$query = $this->db->query("SELECT COUNT(*) as user_count  FROM `sys_user` WHERE `is_active_sys_user` = 1;");
		
		return $query;
	}
	
	function fetch_all_active_yard_vehicles_count_admin()
	{
		$query = $this->db->query("SELECT COUNT(*) as yard_vehicles  FROM `vehicle_details` WHERE `is_active_vhcl_details` = 1;");
		
		return $query;
	}
	
	function fetch_all_active_employee_count_admin()
	{
		$query = $this->db->query("SELECT COUNT(*) AS employee_count  FROM `emp_details` WHERE `is_active_emp` = 1;");
		
		return $query;
	}
	
	function fetch_all_active_customer_count_admin()
	{
		$query = $this->db->query("SELECT COUNT(*) AS customer_count  FROM `customer` WHERE `is_active_customer` = 1;");
		
		return $query;
	}
	
	function fetch_all_complete_retail_order_admin()
	{
		$query = $this->db->query("SELECT COUNT(*) AS customer_count  FROM `customer` WHERE `is_active_customer` = 1;");
		
		return $query;
	}
	
	function fetch_all_complete_rental_order_admin()
	{
		$query = $this->db->query("SELECT COUNT(*) AS rental_order_count  FROM `inventory_rental_invoice_header` WHERE `is_complete` = 1;");
		
		return $query;
	}
	
	function fetch_all_complete_online_order_admin()
	{
		$query = $this->db->query("SELECT COUNT(*) AS online_order_count FROM `online_order` WHERE `is_complete` 1;");
		
		return $query;
	}
}
