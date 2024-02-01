<?php

class Online_feedback_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('feedback_id', 'DESC');
		return $this->db->get('online_feedback');
	}
	
	function insert($data)
	{
		$this->db->insert('online_feedback', $data);
	}

	function fetch_single($feedback_id)
	{
		$this->db->where('feedback_id', $feedback_id);
		$query = $this->db->get('online_feedback');
		return $query->result_array();
	}

	function update_single($feedback_id, $data)
	{
		$this->db->where('feedback_id', $feedback_id);
		$this->db->update('online_feedback', $data);
	}

	function delete_single($feedback_id)
	{
		$this->db->where('feedback_id', $feedback_id);
		$this->db->delete('online_feedback');
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
