<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItemSubItem extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('inventory_item_model');
		$this->load->model('Inventory_sub_item_model');
		$this->load->model('inventory_item_with_sub_items_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->inventory_item_with_sub_items_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{	
		$post = json_decode($this->security->xss_clean($this->input->raw_input_stream));
		//$_POST = json_decode(file_get_contents('php://input'));
		
		$count = count($post);
		//var_dump($_POST[0]);
		//var_dump($this->input->post('main_item_id'));
		$validated = 0;
		foreach ($post as $item) {
			
			if(isset($item->main_item_id) && isset($item->sub_item_id) && isset($item->no_of_sub_items)
			&& trim($item->main_item_id) != '' && trim($item->sub_item_id) != '' && trim($item->no_of_sub_items) != '')
			{
				$validated++;
			}
			else
			{
				$validated--;
			}
						
		} 
		
		
		if($validated == $count){
			foreach ($post as $item) {				
				
				$data = array(
					'main_item_id'	=>	$item->main_item_id,
					'sub_item_id'	=>	$item->sub_item_id,
					'no_of_sub_items'	=>	$item->no_of_sub_items,
					'is_active_item_sub_item' =>	1
				);
				
				$this->inventory_item_with_sub_items_model->insert($data);

				$array = array(
					'success'		=>	true,
					'message'		=>	'Data Saved!'
				);				
				
			}
		}
		else
		{
			$array = array(
				'error'			=>	true,
				'message'		=>	'Error!'
			);
		}
		
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->inventory_item_with_sub_items_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->inventory_item_with_sub_items_model->fetch_all_by_item_id($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->inventory_item_with_sub_items_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->inventory_item_with_sub_items_model->fetch_all();
		
		echo json_encode($data);
	}

	function update()
	{
		
		$post = json_decode($this->security->xss_clean($this->input->raw_input_stream));
		//$_POST = json_decode(file_get_contents('php://input'));
		
		$count = count($post);
		//var_dump($_POST[0]);
		//var_dump($this->input->post('main_item_id'));
		$validated = 0;
		foreach ($post as $item) {
			
			if(isset($item->line_id) && isset($item->main_item_id) && isset($item->sub_item_id) && isset($item->no_of_sub_items)
			&& trim($item->line_id) != '' && trim($item->main_item_id) != '' && trim($item->sub_item_id) != '' && trim($item->no_of_sub_items) != '')
			{
				$validated++;
			}
			else
			{
				$validated--;
			}
						
		} 
		
		
		if($validated == $count){
			
			$status = 0;
			$status += ($this->inventory_item_with_sub_items_model->fetch_all_by_sub_item_id($this->input->post('line_id')))->num_rows();
			
			if($status>0){
				$array = array(
					'error'			=>	true,
					'message'		=>	'Item is being used by other modules at the moment!'
				);
			}
			else{
				foreach ($post as $item) {
					$query = $this->inventory_item_with_sub_items_model->fetch_all_by_line_id($item->line_id);
					$countResult = $query->num_rows();
										
					if($countResult > 0){
						$data = array(
							'line_id'	=>	$item->line_id,
							'main_item_id'	=>	$item->main_item_id,
							'sub_item_id'	=>	$item->sub_item_id,
							'no_of_sub_items'	=>	$item->no_of_sub_items,
							'is_active_item_sub_item' =>	1
						);
						$this->inventory_item_with_sub_items_model->update_single($item->line_id, $data);
					}
					else{
						$data = array(
							'main_item_id'	=>	$item->main_item_id,
							'sub_item_id'	=>	$item->sub_item_id,
							'no_of_sub_items'	=>	$item->no_of_sub_items,
							'is_active_item_sub_item' =>	1
						);
						$this->inventory_item_with_sub_items_model->insert($data);
					}
					
					

					$array = array(
						'success'		=>	true,
						'message'		=>	'Data Saved!'
					);				
					
				}
			}
		}
		else
		{
			$array = array(
				'error'			=>	true,
				'message'		=>	'Error!'
			);
		}
		
		echo json_encode($array);
		
		
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->inventory_item_with_sub_items_model->delete_single($this->input->post('id')))
			{
				$array = array(

					'success'	=>	true
				);
			}
			else
			{
				$array = array(
					'error'		=>	true
				);
			}
			echo json_encode($array);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->inventory_item_with_sub_items_model->fetch_all_join();
		
		echo json_encode($data->result_array());
	}
	
	
}
