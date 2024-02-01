<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_api extends CI_Controller {
	
	function index()
	{
		$this->load->view('api_view');
	}
	
	function action()
	{
		if($this->input->post('data_action')){
			$data_action = $this->input->post('data_action');
			
			switch ($data_action) {
				case "fetch_alls":
					
					$api_url = "http://localhost/api/test_api";
					$client = curl_init($api_url);
					curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
					$response = curl_exec($client);
					curl_close($client);
					$result = json_decode($response);
					$output = '';
					
					if($result)
					{
						foreach($result as $row)
						{
							$output .= '
							<tr>
								<td>'.$row->company_name.'</td>
								<td>'.$row->company_address.'</td>
								<td><butto type="button" name="edit" class="btn btn-warning btn-xs edit" id="'.$row->company_id .'">Edit</button></td>
								<td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row->company_id .'">Delete</button></td>
							</tr>

							';
						}
					}
					else
					{
						$output .= '
						<tr>
							<td colspan="4" align="center">No Data Found</td>
						</tr>
						';
					}

					echo $output;
					
					break;
				case "blue":
					echo "Your favorite color is blue!";
					break;
				case "green":
					echo "Your favorite color is green!";
					break;
				default:
					echo "Your favorite color is neither red, blue, nor green!";
			}
			
		}
	}
	
	/* function action()
	{
		if($this->input->post('data_action'))
		{
			$data_action = $this->input->post('data_action');

			if($data_action == "Delete")
			{
				$api_url = "http://localhost/testapi/api/delete";

				$form_data = array(
					'id'		=>	$this->input->post('user_id')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;




			}

			if($data_action == "Edit")
			{
				$api_url = "http://localhost/testapi/api/update";

				$form_data = array(
					'first_name'		=>	$this->input->post('first_name'),
					'last_name'			=>	$this->input->post('last_name'),
					'id'				=>	$this->input->post('user_id')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;







			}

			if($data_action == "fetch_single")
			{
				$api_url = "http://localhost/testapi/api/fetch_single";

				$form_data = array(
					'id'		=>	$this->input->post('user_id')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;


			}

			if($data_action == "Insert")
			{
				$api_url = "http://localhost/testapi/api/insert";
			

				$form_data = array(
					'first_name'		=>	$this->input->post('first_name'),
					'last_name'			=>	$this->input->post('last_name')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;


			}





			if($data_action == "fetch_all")
			{
				$api_url = "http://localhost/api/test_api";

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				$result = json_decode($response);

				$output = '';

				if($result)
				{
					foreach($result as $row)
					{
						$output .= '
						<tr>
							<td>'.$row->company_name.'</td>
							<td>'.$row->company_address.'</td>
							<td><butto type="button" name="edit" class="btn btn-warning btn-xs edit" id="'.$row->company_id .'">Edit</button></td>
							<td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row->company_id .'">Delete</button></td>
						</tr>

						';
					}
				}
				else
				{
					$output .= '
					<tr>
						<td colspan="4" align="center">No Data Found</td>
					</tr>
					';
				}

				echo $output;
			}
		}
	} */
	
}
