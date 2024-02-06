<?php

class Company_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('company_id', 'DESC');
		return $this->db->get('company');
	}
	
	function insert($data)
	{
		$this->db->insert('company', $data);
	}

	function fetch_single($company_id)
	{
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('company');
		return $query->result_array();
	}
	
	function fetch_single_join($company_id)
	{
		$this->db->select('*');
		$this->db->from('company');
		$this->db->join('country', 'company.company_country = country.country_id','left');
		$this->db->where('company.company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();		
	}
	
	function fetch_all_active()
	{
		$this->db->order_by('company_id', 'ASC');
		$this->db->where('is_active_company', 1);
		return $this->db->get('company');
	}
	
	function fetch_active_join()
	{
		$this->db->select('*');
		$this->db->from('company');
		$this->db->join('country', 'company.company_country = country.country_id','left');
		$this->db->where('company.is_active_company', 1);
		$query = $this->db->get();
		return $query->result_array();		
	}
	
	function fetch_all_by_country_id($country_id)
	{		
		$this->db->select('*');
		$this->db->from('company');
		//$this->db->where('is_active_company', 1);
		$this->db->where('company_country', $country_id);		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('company');
		$this->db->join('country', 'company.company_country = country.country_id','left');
		//$this->db->where('company.company_id', $company_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	function update_single($company_id, $data)
	{
		$this->db->where('company_id', $company_id);
		$this->db->update('company', $data);
	}

	function delete_single($company_id)
	{
		$this->db->where('company_id', $company_id);
		$this->db->delete('company');
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
