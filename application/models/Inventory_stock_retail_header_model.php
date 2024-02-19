<?php

class Inventory_stock_retail_header_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->select('*');
		$this->db->from('inventory_stock_retail_header');
		$this->db->join('inventory_stock_purchase_header', 'inventory_stock_retail_header.stock_batch_id  = inventory_stock_purchase_header.stock_batch_id','left');
		return $query = $this->db->get();
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_stock_retail_header', $data);
		return $this->db->insert_id();
	}

	function fetch_single($retail_stock_header_id)
	{
		$this->db->where('retail_stock_header_id', $retail_stock_header_id);
		$query = $this->db->get('inventory_stock_retail_header');
		return $query->result_array();
	}
	
	function fetch_all_by_branch_id($branch_id)
	{
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get('inventory_stock_retail_header');
		return $query;
	}

	function update_single($retail_stock_header_id, $data)
	{
		$this->db->where('retail_stock_header_id', $retail_stock_header_id);
		$this->db->update('inventory_stock_retail_header', $data);
	}
	
	function fetch_all_by_retail_stock_header_id($retail_stock_header_id)
	{
		$this->db->where('retail_stock_header_id', $retail_stock_header_id);
		$query = $this->db->get('inventory_stock_retail_header');
		return $query;
	}
	
	function fetch_all_by_purchase_stock_header_id($stock_batch_id)
	{
		$this->db->where('stock_batch_id', $stock_batch_id);
		$query = $this->db->get('inventory_stock_retail_header');
		return $query;
	}
	
	function fetch_all_approved_by_retail_stock_header_id($retail_stock_header_id)
	{
		$this->db->where('retail_stock_header_id', $retail_stock_header_id);
		$this->db->where('is_approved_inv_stock_retail', 1);
		$query = $this->db->get('inventory_stock_retail_header');
		return $query;
	}
	

	function delete_single($stock_retail)
	{
		$this->db->where('stock_retail', $stock_retail);
		$this->db->delete('inventory_stock_retail_header');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_single_join($retail_stock_header_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_stock_retail_header');
		$this->db->join('inventory_stock_retail_detail', 'inventory_stock_retail_header.retail_stock_header_id  = inventory_stock_retail_detail.retail_stock_header_id','left');
		//$this->db->group_by('inventory_item_with_sub_items.main_item_id', 'DESC');
		$this->db->where('inventory_stock_retail_header.retail_stock_header_id', $retail_stock_header_id );
		return $query = $this->db->get();
		print_r($this->db->last_query());    
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('inventory_stock_retail_header');
		$this->db->join('inventory_stock_retail_detail', 'inventory_stock_retail_header.retail_stock_header_id  = inventory_stock_retail_detail.retail_stock_header_id','left');
		//$this->db->group_by('inventory_item_with_sub_items.main_item_id', 'DESC');
		$this->db->where('inventory_stock_retail_header.retail_stock_header_id', $retail_stock_header_id );
		return $query = $this->db->get();
		//print_r($this->db->last_query());    
	}
	
	function fetch_all_join_by_branch_id($emp_branch_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_stock_retail_header');
		//$this->db->join('inventory_stock_retail_detail', 'inventory_stock_retail_header.retail_stock_header_id  = inventory_stock_retail_detail.retail_stock_header_id','left');
		$this->db->where('inventory_stock_retail_header.branch_id', $emp_branch_id );
		return $query = $this->db->get();
		//print_r($this->db->last_query());    
	}
	
	function fetch_all_join_by_item_admin()
	{
		$query = $this->db->query("SELECT inventory_stock_retail_header.branch_id, company_branch.company_branch_name , inventory_stock_retail_detail.retail_stock_header_id, inventory_stock_retail_detail.item_id, inventory_stock_retail_detail.max_sale_price, inventory_stock_retail_detail.min_sale_price, inventory_stock_retail_detail.full_stock_count, SUM(inventory_stock_retail_detail.available_stock_count) AS tot_available_stock_count,  inventory_stock_retail_detail.stock_re_order_level, inventory_stock_retail_detail.is_sub_item, inventory_stock_retail_detail.is_active_retail_stock_detail,
		IF(inventory_stock_retail_detail.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM inventory_stock_retail_detail left join inventory_item on inventory_stock_retail_detail.item_id = inventory_item.item_id left join inventory_sub_item on inventory_stock_retail_detail.item_id = inventory_sub_item.sub_item_id left join inventory_stock_retail_header on inventory_stock_retail_detail.retail_stock_header_id = inventory_stock_retail_header.retail_stock_header_id
		left join company_branch ON inventory_stock_retail_header.branch_id = company_branch.company_branch_id
		WHERE inventory_stock_retail_detail.is_active_retail_stock_detail = 1
		GROUP BY inventory_stock_retail_header.branch_id, inventory_stock_retail_detail.item_id, inventory_stock_retail_detail.is_sub_item;");
		
		return $query->result_array();
	}
	
	function fetch_all_join_by_item($emp_branch_id)
	{
		$query = $this->db->query("SELECT inventory_stock_retail_header.branch_id, company_branch.company_branch_name , inventory_stock_retail_detail.retail_stock_header_id, inventory_stock_retail_detail.item_id, inventory_stock_retail_detail.max_sale_price, inventory_stock_retail_detail.min_sale_price, inventory_stock_retail_detail.full_stock_count, SUM(inventory_stock_retail_detail.available_stock_count) AS tot_available_stock_count,inventory_stock_retail_detail.stock_re_order_level, inventory_stock_retail_detail.is_sub_item, inventory_stock_retail_detail.is_active_retail_stock_detail,
		IF(inventory_stock_retail_detail.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM inventory_stock_retail_detail left join inventory_item on inventory_stock_retail_detail.item_id = inventory_item.item_id left join inventory_sub_item on inventory_stock_retail_detail.item_id = inventory_sub_item.sub_item_id left join inventory_stock_retail_header on inventory_stock_retail_detail.retail_stock_header_id = inventory_stock_retail_header.retail_stock_header_id
		left join company_branch ON inventory_stock_retail_header.branch_id = company_branch.company_branch_id WHERE inventory_stock_retail_header.branch_id = '$emp_branch_id' AND inventory_stock_retail_detail.is_active_retail_stock_detail = 1
		GROUP BY inventory_stock_retail_detail.item_id, inventory_stock_retail_detail.is_sub_item;");
		
		return $query->result_array();
	}
	
	function fetch_all_active_retail_products_for_shopping_web()
	{
		$query = $this->db->query("SELECT inventory_retail_total_stock.retail_stock_id, inventory_retail_total_stock.item_id, inventory_retail_total_stock.is_sub_item, inventory_retail_total_stock.max_sale_price, inventory_retail_total_stock.min_sale_price, inventory_retail_total_stock.stock_re_order_level, inventory_item.item_name, inventory_item.item_image_url, inventory_item.item_category  FROM inventory_retail_total_stock LEFT JOIN inventory_item ON inventory_retail_total_stock.item_id = inventory_item.item_id WHERE inventory_item.is_active_inv_item = 1 GROUP BY inventory_retail_total_stock.item_id, inventory_retail_total_stock.is_sub_item;");
		
		return $query;
	}
	
	function fetch_all_active_retail_featured_products_for_shopping_web()
	{
		$query = $this->db->query("SELECT inventory_retail_total_stock.retail_stock_id, inventory_retail_total_stock.item_id, inventory_retail_total_stock.is_sub_item, inventory_retail_total_stock.max_sale_price, inventory_retail_total_stock.min_sale_price, inventory_retail_total_stock.stock_re_order_level, inventory_item.item_name, inventory_item.item_image_url, inventory_item.item_category  FROM inventory_retail_total_stock LEFT JOIN inventory_item ON inventory_retail_total_stock.item_id = inventory_item.item_id WHERE inventory_item.is_active_inv_item = 1 GROUP BY inventory_retail_total_stock.item_id, inventory_retail_total_stock.is_sub_item;");
		
		return $query;
	}
	
	/* function fetch_all_active_retail_products_for_shopping_web()
	{
		$query = $this->db->query("SELECT inventory_retail_total_stock.retail_stock_id, inventory_retail_total_stock.item_id, inventory_retail_total_stock.is_sub_item, inventory_retail_total_stock.max_sale_price, inventory_retail_total_stock.min_sale_price, inventory_retail_total_stock.stock_re_order_level, inventory_item.item_name, inventory_item.item_image_url, inventory_item.item_category  FROM inventory_retail_total_stock LEFT JOIN inventory_item ON inventory_retail_total_stock.item_id = inventory_item.item_id WHERE inventory_item.is_active_inv_item = 1 GROUP BY inventory_retail_total_stock.item_id, inventory_retail_total_stock.is_sub_item;");
		
		return $query;
	} */
	
}
