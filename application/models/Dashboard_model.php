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
		$query = $this->db->query("SELECT COUNT(*) AS retail_order_count FROM `inventory_retail_invoice_header` WHERE `is_complete` = 1;");
		
		return $query;
	}
	
	function fetch_all_complete_rental_order_admin()
	{
		$query = $this->db->query("SELECT COUNT(*) AS rental_order_count  FROM `inventory_rental_invoice_header` WHERE `is_complete` = 1;");
		
		return $query;
	}
	
	function fetch_all_complete_online_order_admin()
	{
		$query = $this->db->query("SELECT COUNT(*) AS online_order_count FROM `online_order` WHERE `is_complete` = 1;");
		
		return $query;
	}
	
	function fetch_all_latest_orders_admin()
	{
		$query = $this->db->query("SELECT order_id, order_type, created_date, is_complete
		FROM (
			SELECT online_order.order_id AS order_id, online_order.is_complete AS is_complete , online_order.created_date AS created_date, 'Online' AS order_type FROM online_order
			UNION
			SELECT inventory_retail_invoice_header.invoice_id AS order_id, inventory_retail_invoice_header.is_complete AS is_complete, inventory_retail_invoice_header.created_date AS created_date, 'Retail' AS order_type FROM inventory_retail_invoice_header
			UNION
			SELECT inventory_rental_invoice_header.invoice_id AS order_id, inventory_rental_invoice_header.is_complete AS is_complete, inventory_rental_invoice_header.created_date AS created_date, 'Rental' AS order_type FROM inventory_rental_invoice_header
		) AS latest_orders
		ORDER BY created_date DESC
		LIMIT 5;");
		
		return $query;
	}
	
	function fetch_all_latest_items_admin()
	{
		$query = $this->db->query("SELECT * FROM `inventory_item` ORDER BY inventory_item.item_id DESC	LIMIT 5;");
		
		return $query;
	}
	
	function fetch_all_branch_wise_sale_admin()
	{
		$query = $this->db->query("SELECT company_branch.company_branch_name, SUM(total) AS total
		FROM (			
			SELECT inventory_retail_invoice_header.branch_id AS branch_id,  inventory_retail_invoice_header.total_amount AS total, inventory_retail_invoice_header.is_complete AS is_complete, STR_TO_DATE(inventory_retail_invoice_header.created_date, '%Y-%m-%d') AS created_date FROM inventory_retail_invoice_header
			UNION
			SELECT inventory_rental_invoice_header.branch_id AS branch_id,  inventory_rental_invoice_header.total_amount AS total, inventory_rental_invoice_header.is_complete AS is_complete, STR_TO_DATE(inventory_rental_invoice_header.created_date, '%Y-%m-%d') AS created_date FROM inventory_rental_invoice_header
		) AS latest_orders
       LEFT JOIN company_branch ON company_branch.company_branch_id = branch_id
       WHERE is_complete = 1 AND MONTH(created_date) = 2
GROUP BY branch_id;");
		
		return $query;
	}
	
	
	
	function fetch_all_active_yard_vehicles_count_manager($branch_id)
	{
		$query = $this->db->query("SELECT COUNT(*) as yard_vehicles  FROM `vehicle_details` WHERE `is_active_vhcl_details` = 1 AND vehicle_details.branch_id = '$branch_id' ;");
		
		return $query;
	}
	
	function fetch_all_active_employee_count_manager($branch_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS employee_count  FROM `emp_details` WHERE `is_active_emp` = 1 
		AND emp_details.emp_branch_id = '$branch_id'");
		
		return $query;
	}
	
	/* function fetch_all_active_customer_count_manager()
	{
		$query = $this->db->query("SELECT COUNT(*) AS customer_count  FROM `customer` WHERE `is_active_customer` = 1;");
		
		return $query;
	} */
	
	function fetch_all_complete_retail_order_manager($branch_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS retail_order_count FROM `inventory_retail_invoice_header` WHERE `is_complete` = 1 AND inventory_retail_invoice_header.branch_id = '$branch_id'");
		
		return $query;
	}
	
	function fetch_all_complete_rental_order_manager($branch_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS rental_order_count  FROM `inventory_rental_invoice_header` WHERE `is_complete` = 1 AND inventory_rental_invoice_header.branch_id = '$branch_id'");
		
		return $query;
	}
	
	/* function fetch_all_complete_online_order_manager()
	{
		$query = $this->db->query("SELECT COUNT(*) AS online_order_count FROM `online_order` WHERE `is_complete` = 1;");
		
		return $query;
	} */
	
	function fetch_all_latest_orders_manager($branch_id)
	{
		$query = $this->db->query("SELECT order_id, order_type, created_date, is_complete
		FROM (
			SELECT inventory_retail_invoice_header.invoice_id AS order_id, inventory_retail_invoice_header.is_complete AS is_complete, inventory_retail_invoice_header.created_date AS created_date, 'Retail' AS order_type FROM inventory_retail_invoice_header WHERE inventory_retail_invoice_header.branch_id = '$branch_id'
			UNION
			SELECT inventory_rental_invoice_header.invoice_id AS order_id, inventory_rental_invoice_header.is_complete AS is_complete, inventory_rental_invoice_header.created_date AS created_date, 'Rental' AS order_type FROM inventory_rental_invoice_header WHERE inventory_rental_invoice_header.branch_id = '$branch_id'
		) AS latest_orders
		ORDER BY created_date DESC
		LIMIT 5;");
		
		return $query;
	}
	
	function fetch_all_latest_items_manager()
	{
		$query = $this->db->query("SELECT * FROM `inventory_item` ORDER BY inventory_item.item_id DESC	LIMIT 5;");
		
		return $query;
	}
	
	function fetch_all_branch_wise_sale_manager($branch_id)
	{
		$query = $this->db->query("SELECT company_branch.company_branch_name, SUM(total) AS total
		FROM (			
			SELECT inventory_retail_invoice_header.branch_id AS branch_id,  inventory_retail_invoice_header.total_amount AS total, inventory_retail_invoice_header.is_complete AS is_complete, STR_TO_DATE(inventory_retail_invoice_header.created_date, '%Y-%m-%d') AS created_date FROM inventory_retail_invoice_header WHERE inventory_retail_invoice_header.branch_id = '$branch_id'
			UNION
			SELECT inventory_rental_invoice_header.branch_id AS branch_id,  inventory_rental_invoice_header.total_amount AS total, inventory_rental_invoice_header.is_complete AS is_complete, STR_TO_DATE(inventory_rental_invoice_header.created_date, '%Y-%m-%d') AS created_date FROM inventory_rental_invoice_header WHERE inventory_rental_invoice_header.branch_id = '$branch_id'
		) AS latest_orders
       LEFT JOIN company_branch ON company_branch.company_branch_id = branch_id
       WHERE is_complete = 1 AND MONTH(created_date) = 2");
		
		return $query;
	}
	
	
	
}
