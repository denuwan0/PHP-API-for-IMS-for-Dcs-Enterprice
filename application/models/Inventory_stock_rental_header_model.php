<?php

class inventory_stock_rental_header_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('rental_stock_header_id', 'ASC');
		return $this->db->get('inventory_stock_rental_header');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_stock_rental_header', $data);
		return $this->db->insert_id();
	}

	function fetch_single($rental_stock_header_id)
	{
		$this->db->where('rental_stock_header_id', $rental_stock_header_id);
		$query = $this->db->get('inventory_stock_rental_header');
		return $query->result_array();
	}
	
	
	function fetch_all_by_purchase_stock_header_id($stock_batch_id)
	{
		$this->db->where('stock_batch_id', $stock_batch_id);
		$query = $this->db->get('inventory_stock_rental_header');
		return $query;
	}
	
	function fetch_all_by_branch_id($branch_id)
	{
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get('inventory_stock_rental_header');
		return $query;
	}

	function update_single($rental_stock_header_id, $data)
	{
		$this->db->where('rental_stock_header_id', $rental_stock_header_id);
		$this->db->update('inventory_stock_rental_header', $data);
	}
	
	function fetch_all_by_stock_batch_id($stock_batch_id)
	{
		$this->db->where('stock_batch_id', $stock_batch_id);
		$query = $this->db->get('inventory_stock_rental_header');
		return $query;
	}

	function delete_single($rental_stock_header_id)
	{
		$this->db->where('rental_stock_header_id', $rental_stock_header_id);
		$this->db->delete('inventory_stock_rental_header');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_all_join_by_item_admin()
	{
		$query = $this->db->query("SELECT inventory_stock_rental_header.branch_id, company_branch.company_branch_name , inventory_stock_rental_detail.rental_stock_header_id, inventory_stock_rental_detail.item_id, inventory_stock_rental_detail.max_rent_price, inventory_stock_rental_detail.min_rent_price, inventory_stock_rental_detail.full_stock_count, inventory_stock_rental_detail.out_stock_count	, inventory_stock_rental_detail.in_stock_count	, inventory_stock_rental_detail.damage_stock_count	, inventory_stock_rental_detail.in_stock_count	, SUM(inventory_stock_rental_detail.in_stock_count) AS tot_available_stock_count,  inventory_stock_rental_detail.stock_re_order_level, inventory_stock_rental_detail.is_sub_item, inventory_stock_rental_detail.repair_stock_count, inventory_stock_rental_detail.is_active_rental_stock_detail,
		IF(inventory_stock_rental_detail.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM inventory_stock_rental_detail left join inventory_item on inventory_stock_rental_detail.item_id = inventory_item.item_id left join inventory_sub_item on inventory_stock_rental_detail.item_id = inventory_sub_item.sub_item_id left join inventory_stock_rental_header on inventory_stock_rental_detail.rental_stock_header_id = inventory_stock_rental_header.rental_stock_header_id
		left join company_branch ON inventory_stock_rental_header.branch_id = company_branch.company_branch_id
		WHERE inventory_stock_rental_detail.is_active_rental_stock_detail = 1
		GROUP BY inventory_stock_rental_header.branch_id, inventory_stock_rental_detail.item_id, inventory_stock_rental_detail.is_sub_item;");
		
		return $query->result_array();
	}
	
	function fetch_all_join_by_item($emp_branch_id)
	{
		$query = $this->db->query("SELECT inventory_stock_rental_header.branch_id, company_branch.company_branch_name , inventory_stock_rental_detail.rental_stock_header_id, inventory_stock_rental_detail.item_id, inventory_stock_rental_detail.max_rent_price, inventory_stock_rental_detail.min_rent_price, inventory_stock_rental_detail.full_stock_count, inventory_stock_rental_detail.out_stock_count	, inventory_stock_rental_detail.in_stock_count	, inventory_stock_rental_detail.damage_stock_count	, inventory_stock_rental_detail.in_stock_count	, SUM(inventory_stock_rental_detail.in_stock_count) AS tot_available_stock_count,  inventory_stock_rental_detail.stock_re_order_level, inventory_stock_rental_detail.is_sub_item, inventory_stock_rental_detail.repair_stock_count, inventory_stock_rental_detail.is_active_rental_stock_detail,
		IF(inventory_stock_rental_detail.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM inventory_stock_rental_detail left join inventory_item on inventory_stock_rental_detail.item_id = inventory_item.item_id left join inventory_sub_item on inventory_stock_rental_detail.item_id = inventory_sub_item.sub_item_id left join inventory_stock_rental_header on inventory_stock_rental_detail.rental_stock_header_id = inventory_stock_rental_header.rental_stock_header_id
		left join company_branch ON inventory_stock_rental_header.branch_id = company_branch.company_branch_id
		WHERE inventory_stock_rental_header.branch_id = '$emp_branch_id' AND inventory_stock_rental_detail.is_active_rental_stock_detail = 1
		GROUP BY inventory_stock_rental_header.branch_id, inventory_stock_rental_detail.item_id, inventory_stock_rental_detail.is_sub_item;");
		
		return $query->result_array();
	}
	
}
