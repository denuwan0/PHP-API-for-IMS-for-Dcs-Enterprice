<?php

class Inventory_retail_total_stock_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('retail_stock_id', 'ASC');
		return $this->db->get('inventory_retail_total_stock');
	}
	
	function fetch_all_active(){
		$this->db->order_by('retail_stock_id', 'ASC');
		$this->db->where('is_active_retail_stock', 1);
		return $this->db->get('inventory_retail_total_stock');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_retail_total_stock', $data);
	}

	function fetch_single($retail_stock_id)
	{
		$this->db->where('retail_stock_id', $retail_stock_id);
		$query = $this->db->get('inventory_retail_total_stock');
		return $query->result_array();
	}
	
	function fetch_single_by_branch_id_item_id_is_sub($item_id, $branch_id, $is_sub_item)
	{
		$this->db->where('item_id', $item_id);
		$this->db->where('is_sub_item', $is_sub_item);
		$this->db->where('branch_id', $branch_id);
		$this->db->where('is_active_retail_stock', 1);
		$query = $this->db->get('inventory_retail_total_stock');
		return $query->result_array();
	}
		
	function fetch_single_join($retail_stock_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_retail_total_stock');
		$this->db->join('inventory_retail_total_stock_category', 'inventory_retail_total_stock.item_category = inventory_retail_total_stock_category.item_category_id','left');
		$this->db->where('inventory_retail_total_stock.retail_stock_id', $retail_stock_id);
		
		return $query = $this->db->get();
	}

	function update_single($retail_stock_id, $data)
	{
		$this->db->where('retail_stock_id', $retail_stock_id);
		$this->db->update('inventory_retail_total_stock', $data);
	}
	
	function update_all_by_item_id($item_id, $data)
	{
		$this->db->where('item_id', $item_id);
		$this->db->update('inventory_retail_total_stock', $data);
	}

	function delete_single($retail_stock_id)
	{
		$this->db->where('retail_stock_id', $retail_stock_id);
		$this->db->delete('inventory_retail_total_stock');
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
		$query = $this->db->query("SELECT inventory_retail_total_stock.retail_stock_id, inventory_retail_total_stock.item_id, inventory_retail_total_stock.is_sub_item, inventory_retail_total_stock.max_sale_price, inventory_retail_total_stock.min_sale_price, inventory_retail_total_stock.full_stock_count, inventory_retail_total_stock.stock_re_order_level, inventory_retail_total_stock.branch_id, company_branch.company_branch_name, inventory_retail_total_stock.is_active_retail_stock, IF(inventory_retail_total_stock.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM `inventory_retail_total_stock` left join inventory_item on  inventory_retail_total_stock.item_id = inventory_item.item_id left join inventory_sub_item on  inventory_retail_total_stock.item_id = inventory_sub_item.sub_item_id left join company_branch ON  inventory_retail_total_stock.branch_id = company_branch.company_branch_id;");

		return $query;
	}
	
	function fetch_all_join_by_branch_id($branch_id)
	{
		$query = $this->db->query("SELECT inventory_retail_total_stock.retail_stock_id, inventory_retail_total_stock.item_id, inventory_retail_total_stock.is_sub_item, inventory_retail_total_stock.max_sale_price, inventory_retail_total_stock.min_sale_price, inventory_retail_total_stock.full_stock_count, inventory_retail_total_stock.stock_re_order_level, inventory_retail_total_stock.branch_id, company_branch.company_branch_name, inventory_retail_total_stock.is_active_retail_stock, IF(inventory_retail_total_stock.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM `inventory_retail_total_stock` left join inventory_item on  inventory_retail_total_stock.item_id = inventory_item.item_id left join inventory_sub_item on  inventory_retail_total_stock.item_id = inventory_sub_item.sub_item_id left join company_branch ON  inventory_retail_total_stock.branch_id = company_branch.company_branch_id WHERE inventory_retail_total_stock.branch_id = '$branch_id';");

		return $query;
	}
	
	function fetch_all_join_by_stock_id($stock_id)
	{
		$query = $this->db->query("SELECT inventory_retail_total_stock.retail_stock_id, inventory_retail_total_stock.item_id, inventory_retail_total_stock.is_sub_item, inventory_retail_total_stock.max_sale_price, inventory_retail_total_stock.min_sale_price, inventory_retail_total_stock.full_stock_count, inventory_retail_total_stock.stock_re_order_level, inventory_retail_total_stock.branch_id, company_branch.company_branch_name, inventory_retail_total_stock.is_active_retail_stock, IF(inventory_retail_total_stock.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM `inventory_retail_total_stock` left join inventory_item on  inventory_retail_total_stock.item_id = inventory_item.item_id left join inventory_sub_item on  inventory_retail_total_stock.item_id = inventory_sub_item.sub_item_id left join company_branch ON  inventory_retail_total_stock.branch_id = company_branch.company_branch_id WHERE inventory_retail_total_stock.retail_stock_id = '$stock_id';");
		//echo $this->db->last_query();
		return $query;
	}
	
	function get_retail_item_details_by_item_id_branch_id_is_sub_item($item_id, $branch_id, $is_sub_item)
	{
		$query = $this->db->query("SELECT inventory_retail_total_stock.retail_stock_id, inventory_retail_total_stock.item_id, inventory_retail_total_stock.is_sub_item, inventory_retail_total_stock.max_sale_price, inventory_retail_total_stock.min_sale_price, inventory_retail_total_stock.full_stock_count, inventory_retail_total_stock.stock_re_order_level, inventory_retail_total_stock.branch_id, company_branch.company_branch_name, inventory_retail_total_stock.is_active_retail_stock, IF(inventory_retail_total_stock.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM `inventory_retail_total_stock` left join inventory_item on  inventory_retail_total_stock.item_id = inventory_item.item_id left join inventory_sub_item on  inventory_retail_total_stock.item_id = inventory_sub_item.sub_item_id left join company_branch ON  inventory_retail_total_stock.branch_id = company_branch.company_branch_id WHERE inventory_retail_total_stock.item_id = $item_id AND inventory_retail_total_stock.is_sub_item = $is_sub_item AND inventory_retail_total_stock.branch_id = $branch_id;");
		//echo $this->db->last_query();
		return $query;
	}
	
	function fetch_item_detail_for_shopping_web($item_id)
	{
		$query = $this->db->query("SELECT inventory_retail_total_stock.retail_stock_id, inventory_retail_total_stock.item_id, inventory_retail_total_stock.is_sub_item,  IF(inventory_retail_total_stock.min_sale_price = 0, inventory_retail_total_stock.max_sale_price, inventory_retail_total_stock.min_sale_price) AS sale_price, inventory_retail_total_stock.full_stock_count, inventory_retail_total_stock.stock_re_order_level, inventory_retail_total_stock.branch_id, company_branch.company_branch_name, inventory_retail_total_stock.is_active_retail_stock, inventory_item.item_name, inventory_item.item_id, inventory_item.item_image_url, inventory_item.item_type, inventory_item.item_category, inventory_item.is_active_inv_item, inventory_item.is_feature, inventory_item.is_web_pattern, inventory_item.item_desc FROM `inventory_retail_total_stock` left join inventory_item on  inventory_retail_total_stock.item_id = inventory_item.item_id  left join company_branch ON  inventory_retail_total_stock.branch_id = company_branch.company_branch_id WHERE inventory_item.item_id = '$item_id' GROUP BY inventory_item.item_id;");
		//echo $this->db->last_query();
		return $query;
	}
	
}
