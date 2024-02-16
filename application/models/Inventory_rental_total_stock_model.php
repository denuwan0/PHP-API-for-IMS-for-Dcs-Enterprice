<?php

class Inventory_rental_total_stock_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('rental_stock_id', 'ASC');
		return $this->db->get('inventory_rental_total_stock');
	}
	
	function fetch_all_active(){
		$this->db->order_by('rental_stock_id', 'ASC');
		$this->db->where('is_active_rental_stock', 1);
		return $this->db->get('inventory_rental_total_stock');
	}
	
	function insert($data)
	{
		$this->db->insert('inventory_rental_total_stock', $data);
	}

	function fetch_single($rental_stock_id)
	{
		$this->db->where('rental_stock_id', $rental_stock_id);
		$query = $this->db->get('inventory_rental_total_stock');
		return $query->result_array();
	}
	
	function fetch_single_join($rental_stock_id)
	{
		$this->db->select('*');
		$this->db->from('inventory_rental_total_stock');
		$this->db->join('inventory_rental_total_stock_category', 'inventory_rental_total_stock.item_category = inventory_rental_total_stock_category.item_category_id','left');
		$this->db->where('inventory_rental_total_stock.rental_stock_id', $rental_stock_id);
		
		return $query = $this->db->get();
	}

	function update_single($rental_stock_id, $data)
	{
		$this->db->where('rental_stock_id', $rental_stock_id);
		$this->db->update('inventory_rental_total_stock', $data);
	}

	function delete_single($rental_stock_id)
	{
		$this->db->where('rental_stock_id', $rental_stock_id);
		$this->db->delete('inventory_rental_total_stock');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
		
	function fetch_single_by_branch_id_item_id_is_sub($item_id, $branch_id, $is_sub_item)
	{
		$this->db->where('item_id', $item_id);
		$this->db->where('is_sub_item', $is_sub_item);
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get('inventory_rental_total_stock');
		return $query->result_array();
	}
	
	function fetch_all_join()
	{
		$query = $this->db->query("SELECT inventory_rental_total_stock.rental_stock_id, inventory_rental_total_stock.item_id, inventory_rental_total_stock.is_sub_item, inventory_rental_total_stock.full_stock_count, inventory_rental_total_stock.out_stock_count, inventory_rental_total_stock.branch_id, inventory_rental_total_stock.max_rent_price, inventory_rental_total_stock.min_rent_price, inventory_rental_total_stock.damage_stock_count, inventory_rental_total_stock.repair_stock_count, inventory_rental_total_stock.stock_re_order_level, inventory_rental_total_stock.is_active_rental_stock, company_branch.company_branch_name, IF(inventory_rental_total_stock.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM `inventory_rental_total_stock` left join inventory_item on  inventory_rental_total_stock.item_id = inventory_item.item_id left join inventory_sub_item on  inventory_rental_total_stock.item_id = inventory_sub_item.sub_item_id left join company_branch ON  inventory_rental_total_stock.branch_id = company_branch.company_branch_id");

		return $query;
	}
	
	function fetch_all_join_by_branch_id($branch_id)
	{
		$query = $this->db->query("SELECT inventory_rental_total_stock.rental_stock_id, inventory_rental_total_stock.item_id, inventory_rental_total_stock.is_sub_item, inventory_rental_total_stock.full_stock_count, inventory_rental_total_stock.out_stock_count, inventory_rental_total_stock.branch_id, inventory_rental_total_stock.max_rent_price, inventory_rental_total_stock.min_rent_price, inventory_rental_total_stock.damage_stock_count, inventory_rental_total_stock.repair_stock_count, inventory_rental_total_stock.stock_re_order_level, inventory_rental_total_stock.is_active_rental_stock, company_branch.company_branch_name, IF(inventory_rental_total_stock.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM `inventory_rental_total_stock` left join inventory_item on  inventory_rental_total_stock.item_id = inventory_item.item_id left join inventory_sub_item on  inventory_rental_total_stock.item_id = inventory_sub_item.sub_item_id left join company_branch ON  inventory_rental_total_stock.branch_id = company_branch.company_branch_id WHERE inventory_rental_total_stock.branch_id = '$branch_id'");

		return $query;
	}
	
	function fetch_all_join_by_stock_id($stock_id)
	{
		$query = $this->db->query("SELECT inventory_rental_total_stock.rental_stock_id, inventory_rental_total_stock.item_id, inventory_rental_total_stock.is_sub_item, inventory_rental_total_stock.full_stock_count, inventory_rental_total_stock.out_stock_count, inventory_rental_total_stock.branch_id, inventory_rental_total_stock.max_rent_price, inventory_rental_total_stock.min_rent_price, inventory_rental_total_stock.damage_stock_count, inventory_rental_total_stock.repair_stock_count, company_branch.company_branch_name, inventory_rental_total_stock.stock_re_order_level, inventory_rental_total_stock.is_active_rental_stock,
		IF(inventory_rental_total_stock.is_sub_item = 0, inventory_item.item_name, inventory_sub_item.sub_item_name)  as item_name FROM `inventory_rental_total_stock` left join inventory_item on  inventory_rental_total_stock.item_id = inventory_item.item_id left join inventory_sub_item on  inventory_rental_total_stock.item_id = inventory_sub_item.sub_item_id left join company_branch ON  inventory_rental_total_stock.branch_id = company_branch.company_branch_id WHERE inventory_rental_total_stock.rental_stock_id = '$stock_id'");
		//echo $this->db->last_query();
		return $query;
	}
	
}
