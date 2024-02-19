<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItemCategory extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('inventory_item_category_model');
		$this->load->model('inventory_item_sub_category_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->inventory_item_category_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('category_name', 'Category Name', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		
		if($this->form_validation->run())
		{
			$image_upload_path = "";
			
			if($_FILES['cat_img_url']['name'] != '' && ($_FILES['cat_img_url']['type'] == 'image/jpeg' || $_FILES['cat_img_url']['type'] == 'image/png')){
				$test = explode('.', $_FILES['cat_img_url']['name']);
				$extension = end($test);    
				$name = $_FILES['cat_img_url']['name'];
				$image_upload_path = $_SERVER["DOCUMENT_ROOT"].'/API/assets/img/category/'.$name;
				
				if(move_uploaded_file($_FILES['cat_img_url']['tmp_name'], $image_upload_path)){
					
					$cat_img_url = base_url().'assets/img/category/'.$name;
				}
			}
			else{
				$image_upload_path = $_SERVER["DOCUMENT_ROOT"]."/API/assets/img/download.png";
			}
			
			$data = array(
				'category_name'	=>	$this->input->post('category_name'),
				'description'	=>	$this->input->post('description'),
				'cat_img_url'	=>	$cat_img_url,
				'is_active_inv_item_cat' =>	$this->input->post('is_active_inv_item_cat')
			);

			$this->inventory_item_category_model->insert($data);

			$array = array(
				'success'		=>	true,
				'message'		=>	'Data Saved!'
			);
		}
		else
		{
			$array = array(
				'error'			=>	true,
				'message'		=>	'Error!',
				'company_id'	=>	form_error('company_id'),
				'bank_name'	=>	form_error('bank_name')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->inventory_item_category_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->inventory_item_category_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->inventory_item_category_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->inventory_item_category_model->fetch_all();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('item_category_id', 'Category Id', 'required');
		$this->form_validation->set_rules('category_name', 'Category Name', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		
				
		if($this->form_validation->run())
		{	

			$image_upload_path = "";
			$cat_img_url = "";

			if(isset($_FILES['cat_img_url']['name']) && $_FILES['cat_img_url']['name'] != '' && ($_FILES['cat_img_url']['type'] == 'image/jpeg' || $_FILES['cat_img_url']['type'] == 'image/png')){
				$test = explode('.', $_FILES['cat_img_url']['name']);
				$extension = end($test);    
				$name = $_FILES['cat_img_url']['name'];
				$image_upload_path = $_SERVER["DOCUMENT_ROOT"].'/API/assets/img/category/'.$name;
				
				if(move_uploaded_file($_FILES['cat_img_url']['tmp_name'], $image_upload_path)){
					
					$cat_img_url = base_url().'assets/img/category/'.$name;
				}
			}
			else{
				$cat_img_url = $this->input->post('old_image');
			}
				
	
			if($this->input->post('is_active_inv_item_cat') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('item_category_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
							
				$status = 0;
				$status += ($this->inventory_item_sub_category_model->fetch_all_by_item_category_id($this->input->post('item_category_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Item Category is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'item_category_id'	=>	$this->input->post('item_category_id'),
						'category_name'	=>	$this->input->post('category_name'),
						'cat_img_url'	=>	$cat_img_url,
						'description'	=>	$this->input->post('description'),
						'is_active_inv_item_cat'	=>	$this->input->post('is_active_inv_item_cat')
					);
					
					$this->inventory_item_category_model->update_single($this->input->post('item_category_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'item_category_id'	=>	$this->input->post('item_category_id'),
					'category_name'	=>	$this->input->post('category_name'),
					'cat_img_url'	=>	$cat_img_url,
					'description'	=>	$this->input->post('description'),
					'is_active_inv_item_cat'	=>	$this->input->post('is_active_inv_item_cat')
				);

				$this->inventory_item_category_model->update_single($this->input->post('item_category_id'), $data);

				$array = array(
					'success'		=>	true,
					'message'		=>	'Changes Updated!'
				);
			}			
			
		}
		else
		{
			$array = array(
				'error'			=>	true,
				'message'		=>	'Please Fill Required Fields!'
			);
		}
		
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->inventory_item_category_model->delete_single($this->input->post('id')))
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
	
}
